import { useState, useEffect, useMemo } from "react";
import { Button } from "@/components/ui/button";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Input } from "@/components/ui/input";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow
} from "@/components/ui/table";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger
} from "@/components/ui/tooltip";
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from "@/components/ui/dropdown-menu";
import { Skeleton } from "@/components/ui/skeleton";
import AppLayout from "@/layouts/app-layout";
import { type BreadcrumbItem } from "@/types";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import {
    CheckCircle2Icon,
    EyeIcon,
    PencilIcon,
    TrashIcon,
    Plus,
    ArrowUpDown,
    ArrowUp,
    ArrowDown,
    ArrowLeft,
    ArrowRight,
    Filter as FilterIcon,
    ChevronDown,
    MoreHorizontal
} from "lucide-react";
import {
    ColumnDef,
    ColumnFiltersState,
    flexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useReactTable,
    VisibilityState,
    PaginationState,
    SortingState
} from "@tanstack/react-table";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue
} from "@/components/ui/select";

const breadcrumbs: BreadcrumbItem[] = [{ title: "Enrollments", href: "/enrollments" }];

interface AuthUser {
    id: number;
    name: string;
    role_id: number;
    tenant_id?: number;
}

interface TenantOption {
    id: number;
    name: string;
}

interface StudentOption {
    id: number;
    first_name: string;
    last_name: string;
}

interface CourseOption {
    id: number;
    name: string;
}

interface PageProps {
    flash: { message?: string };
    enrollments: Enrollment[];
    availableTenants: TenantOption[];
    availableStudents: StudentOption[];
    availableCourses: CourseOption[];
    isSuperAdmin: boolean;
    auth: { user: AuthUser };
}

interface Enrollment {
    id: number;
    tenant_id: number;
    student_id: number;
    course_id: number;
    fee: number;
    tenant?: { id: number; name: string };
    student?: { id: number; first_name: string; last_name: string };
    course?: { id: number; name: string };
}

const getColumns = (
    setEnrollmentToDelete: React.Dispatch<React.SetStateAction<Enrollment | null>>,
    processing: boolean,
    isSuperAdmin: boolean,
    availableTenants: TenantOption[],
    availableStudents: StudentOption[],
    availableCourses: CourseOption[],
    isTenantDropdownOpen: boolean,
    setIsTenantDropdownOpen: React.Dispatch<React.SetStateAction<boolean>>,
    isStudentDropdownOpen: boolean,
    setIsStudentDropdownOpen: React.Dispatch<React.SetStateAction<boolean>>,
    isCourseDropdownOpen: boolean,
    setIsCourseDropdownOpen: React.Dispatch<React.SetStateAction<boolean>>
): ColumnDef<Enrollment>[] => [
    {
        accessorKey: "id",
        header: ({ column }) => (
            <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                ID
                {column.getIsSorted() === "asc" ? <ArrowUp className="ml-2 h-4 w-4" /> :
                    column.getIsSorted() === "desc" ? <ArrowDown className="ml-2 h-4 w-4" /> :
                        <ArrowUpDown className="ml-2 h-4 w-4" />}
            </Button>
        ),
        cell: ({ row }) => <div className="px-3">{row.getValue("id")}</div>
    },
    {
        accessorKey: "student",
        header: ({ column }) => (
            <div className="flex items-center space-x-2">
                <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                    Student
                    {column.getIsSorted() === "asc" ? <ArrowUp className="ml-2 h-4 w-4" /> :
                        column.getIsSorted() === "desc" ? <ArrowDown className="ml-2 h-4 w-4" /> :
                            <ArrowUpDown className="ml-2 h-4 w-4" />}
                </Button>
                <DropdownMenu open={isStudentDropdownOpen} onOpenChange={setIsStudentDropdownOpen}>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger asChild>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                        <FilterIcon className={`h-4 w-4 ${column.getFilterValue() ? 'text-blue-500' : 'text-gray-400'}`} />
                                        <span className="sr-only">Open filter menu</span>
                                    </Button>
                                </DropdownMenuTrigger>
                            </TooltipTrigger>
                            <TooltipContent>Filter by Student</TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                    <DropdownMenuContent align="start" className="p-2 w-[180px]">
                        <Select
                            value={(column.getFilterValue() as string) || ""}
                            onValueChange={(value) => {
                                column.setFilterValue(value === "All" ? "" : value);
                                setIsStudentDropdownOpen(false);
                            }}
                        >
                            <SelectTrigger className="w-full">
                                <SelectValue placeholder="Select Student" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="All">All Students</SelectItem>
                                {availableStudents.map(student => (
                                    <SelectItem key={student.id} value={`${student.first_name} ${student.last_name}`}>
                                        {student.first_name} {student.last_name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        ),
        cell: ({ row }) => (
            <div className="px-3">
                {row.original.student ? `${row.original.student.first_name} ${row.original.student.last_name}` : 'N/A'}
            </div>
        ),
        filterFn: (row, columnId, filterValue) => {
            const studentName = row.original.student
                ? `${row.original.student.first_name} ${row.original.student.last_name}`.toLowerCase()
                : '';
            return studentName.includes(String(filterValue).toLowerCase());
        },
        sortingFn: (rowA, rowB) => {
            const nameA = rowA.original.student
                ? `${rowA.original.student.first_name} ${rowA.original.student.last_name}`.toLowerCase()
                : '';
            const nameB = rowB.original.student
                ? `${rowB.original.student.first_name} ${rowB.original.student.last_name}`.toLowerCase()
                : '';
            return nameA.localeCompare(nameB);
        },
        enableSorting: true
    },
    {
        accessorKey: "course",
        header: ({ column }) => (
            <div className="flex items-center space-x-2">
                <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                    Course
                    {column.getIsSorted() === "asc" ? <ArrowUp className="ml-2 h-4 w-4" /> :
                        column.getIsSorted() === "desc" ? <ArrowDown className="ml-2 h-4 w-4" /> :
                            <ArrowUpDown className="ml-2 h-4 w-4" />}
                </Button>
                <DropdownMenu open={isCourseDropdownOpen} onOpenChange={setIsCourseDropdownOpen}>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger asChild>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                        <FilterIcon className={`h-4 w-4 ${column.getFilterValue() ? 'text-blue-500' : 'text-gray-400'}`} />
                                        <span className="sr-only">Open filter menu</span>
                                    </Button>
                                </DropdownMenuTrigger>
                            </TooltipTrigger>
                            <TooltipContent>Filter by Course</TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                    <DropdownMenuContent align="start" className="p-2 w-[180px]">
                        <Select
                            value={(column.getFilterValue() as string) || ""}
                            onValueChange={(value) => {
                                column.setFilterValue(value === "All" ? "" : value);
                                setIsCourseDropdownOpen(false);
                            }}
                        >
                            <SelectTrigger className="w-full">
                                <SelectValue placeholder="Select Course" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="All">All Courses</SelectItem>
                                {availableCourses.map(course => (
                                    <SelectItem key={course.id} value={course.name}>
                                        {course.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        ),
        cell: ({ row }) => (
            <div className="px-3">{row.original.course?.name || 'N/A'}</div>
        ),
        filterFn: (row, columnId, filterValue) => {
            const courseName = row.original.course?.name?.toLowerCase() || '';
            return courseName.includes(String(filterValue).toLowerCase());
        },
        sortingFn: (rowA, rowB) => {
            const nameA = rowA.original.course?.name?.toLowerCase() || '';
            const nameB = rowB.original.course?.name?.toLowerCase() || '';
            return nameA.localeCompare(nameB);
        },
        enableSorting: true
    },
    {
        accessorKey: "fee",
        header: ({ column }) => (
            <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                Fee
                {column.getIsSorted() === "asc" ? <ArrowUp className="ml-2 h-4 w-4" /> :
                    column.getIsSorted() === "desc" ? <ArrowDown className="ml-2 h-4 w-4" /> :
                        <ArrowUpDown className="ml-2 h-4 w-4" />}
            </Button>
        ),
        cell: ({ row }) => (
            <div className="px-3">${Number(row.getValue("fee")).toFixed(2)}</div>
        )
    },
    ...(isSuperAdmin ? [{
        accessorKey: "tenant.name",
        header: ({ column }) => (
            <div className="flex items-center space-x-2">
                <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                    Tenant
                    {column.getIsSorted() === "asc" ? <ArrowUp className="ml-2 h-4 w-4" /> :
                        column.getIsSorted() === "desc" ? <ArrowDown className="ml-2 h-4 w-4" /> :
                            <ArrowUpDown className="ml-2 h-4 w-4" />}
                </Button>
                <DropdownMenu open={isTenantDropdownOpen} onOpenChange={setIsTenantDropdownOpen}>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger asChild>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                        <FilterIcon className={`h-4 w-4 ${column.getFilterValue() ? 'text-blue-500' : 'text-gray-400'}`} />
                                        <span className="sr-only">Open filter menu</span>
                                    </Button>
                                </DropdownMenuTrigger>
                            </TooltipTrigger>
                            <TooltipContent>Filter by Tenant</TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                    <DropdownMenuContent align="start" className="p-2 w-[180px]">
                        <Select
                            value={(column.getFilterValue() as string) || ""}
                            onValueChange={(value) => {
                                column.setFilterValue(value === "All" ? "" : value);
                                setIsTenantDropdownOpen(false);
                            }}
                        >
                            <SelectTrigger className="w-full">
                                <SelectValue placeholder="Select Tenant" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="All">All Tenants</SelectItem>
                                {availableTenants.map(tenant => (
                                    <SelectItem key={tenant.id} value={tenant.name}>
                                        {tenant.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        ),
        cell: ({ row }) => (
            <div className="px-3">{row.original.tenant?.name || 'N/A'}</div>
        ),
        filterFn: (row, columnId, filterValue) => {
            const tenantName = row.original.tenant?.name?.toLowerCase() || '';
            return tenantName.includes(String(filterValue).toLowerCase());
        },
        enableSorting: true
    }] : []),
    {
        id: "actions",
        enableHiding: false,
        enableGlobalFilter: false,
        enableSorting: false,
        cell: ({ row }) => {
            const enrollment = row.original;
            return (
                <TooltipProvider>
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" className="h-8 w-8 p-0">
                                <span className="sr-only">Open menu</span>
                                <MoreHorizontal className="h-4 w-4" />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="center" className="w-auto min-w-0">
                            <DropdownMenuItem asChild className="p-1">
                                <Link href={route("enrollments.show", enrollment.id)}>
                                    <Tooltip>
                                        <TooltipTrigger asChild>
                                            <Button variant="ghost" className="h-4 w-4 p-0 cursor-pointer">
                                                <EyeIcon className="h-4 w-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent side="right" align="center">View</TooltipContent>
                                    </Tooltip>
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem asChild className="p-1">
                                <Link href={route("enrollments.edit", enrollment.id)}>
                                    <Tooltip>
                                        <TooltipTrigger asChild>
                                            <Button variant="ghost" className="h-4 w-4 p-0 cursor-pointer">
                                                <PencilIcon className="h-4 w-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent side="right" align="center">Edit</TooltipContent>
                                    </Tooltip>
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem
                                onClick={() => setEnrollmentToDelete(enrollment)}
                                className="text-red-600 p-1"
                                disabled={processing}
                            >
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button variant="ghost" className="h-4 w-4 p-0 cursor-pointer">
                                            <TrashIcon className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent side="right" align="center">Delete</TooltipContent>
                                </Tooltip>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </TooltipProvider>
            );
        }
    }
];

function Index() {
    const { flash, enrollments, isSuperAdmin, availableTenants, availableStudents, availableCourses } = usePage<PageProps>().props;
    const [showAlert, setShowAlert] = useState(false);
    const { processing, delete: destroy } = useForm();
    const [enrollmentToDelete, setEnrollmentToDelete] = useState<Enrollment | null>(null);
    const [isTableLoading, setIsTableLoading] = useState(true);
    const [isTenantDropdownOpen, setIsTenantDropdownOpen] = useState(false);
    const [isStudentDropdownOpen, setIsStudentDropdownOpen] = useState(false);
    const [isCourseDropdownOpen, setIsCourseDropdownOpen] = useState(false);
    const [sorting, setSorting] = useState<SortingState>([]);
    const [columnFilters, setColumnFilters] = useState<ColumnFiltersState>([]);
    const [columnVisibility, setColumnVisibility] = useState<VisibilityState>({});
    const [rowSelection, setRowSelection] = useState({});
    const [pagination, setPagination] = useState<PaginationState>({ pageIndex: 0, pageSize: 10 });
    const [globalFilter, setGlobalFilter] = useState('');

    const columns = useMemo(() => getColumns(
        setEnrollmentToDelete,
        processing,
        isSuperAdmin,
        availableTenants,
        availableStudents,
        availableCourses,
        isTenantDropdownOpen,
        setIsTenantDropdownOpen,
        isStudentDropdownOpen,
        setIsStudentDropdownOpen,
        isCourseDropdownOpen,
        setIsCourseDropdownOpen
    ), [
        setEnrollmentToDelete,
        processing,
        isSuperAdmin,
        availableTenants,
        availableStudents,
        availableCourses,
        isTenantDropdownOpen,
        isStudentDropdownOpen,
        isCourseDropdownOpen
    ]);

    const table = useReactTable({
        data: enrollments,
        columns,
        onSortingChange: setSorting,
        onColumnFiltersChange: setColumnFilters,
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
        onColumnVisibilityChange: setColumnVisibility,
        onRowSelectionChange: setRowSelection,
        onPaginationChange: setPagination,
        onGlobalFilterChange: setGlobalFilter,
        globalFilterFn: (row, columnId, filterValue) => {
            const search = String(filterValue).toLowerCase();
            const studentName = row.original.student
                ? `${row.original.student.first_name} ${row.original.student.last_name}`.toLowerCase()
                : '';
            const courseName = row.original.course?.name?.toLowerCase() || '';
            return studentName.includes(search) || courseName.includes(search);
        },
        state: {
            sorting,
            columnFilters,
            columnVisibility,
            rowSelection,
            pagination,
            globalFilter
        },
        initialState: {
            pagination: { pageSize: 10 },
            columnVisibility: { 'tenant.name': isSuperAdmin }
        }
    });

    useEffect(() => {
        if (flash.message) setShowAlert(true);
        const timer = setTimeout(() => setIsTableLoading(false), 500);
        return () => clearTimeout(timer);
    }, [flash.message, enrollments]);

    const handleCloseAlert = () => setShowAlert(false);

    const confirmDelete = () => {
        if (enrollmentToDelete) {
            destroy(route("enrollments.destroy", enrollmentToDelete.id), {
                onSuccess: () => setEnrollmentToDelete(null),
                onError: () => setEnrollmentToDelete(null)
            });
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="List of Enrollments" />
            <div className="p-4 sm:p-6 lg:p-5 xl:p-2">
                {showAlert && flash.message && (
                    <Alert className="mb-0 flex items-start justify-between">
                        <div className="flex gap-2">
                            <CheckCircle2Icon className="h-4 w-4" />
                            <div>
                                <AlertTitle>New Notification</AlertTitle>
                                <AlertDescription>{flash.message}</AlertDescription>
                            </div>
                        </div>
                        <Button onClick={handleCloseAlert} className="text-sm font-medium cursor-pointer" disabled={processing}>
                            ×
                        </Button>
                    </Alert>
                )}
                <div className="flex flex-wrap items-center justify-between gap-2 py-4">
                    <div className="flex items-center gap-2 flex-wrap">
                        <Input
                            placeholder="Search"
                            value={globalFilter ?? ""}
                            onChange={(event) => setGlobalFilter(event.target.value)}
                            className="max-w-sm flex-grow sm:flex-grow-0"
                            disabled={isTableLoading || processing}
                        />
                    </div>
                    <div className="flex items-center gap-2 ml-auto flex-wrap">
                        <div className="flex items-center space-x-2">
                            <span className="text-sm font-medium whitespace-nowrap">Rows per page:</span>
                            <Select
                                value={String(table.getState().pagination.pageSize)}
                                onValueChange={(value) => {
                                    table.setPageSize(value === "All" ? table.getFilteredRowModel().rows.length : Number(value));
                                }}
                                disabled={isTableLoading || processing}
                            >
                                <SelectTrigger className="h-8 w-[120px]">
                                    <SelectValue placeholder={String(table.getState().pagination.pageSize)} />
                                </SelectTrigger>
                                <SelectContent>
                                    {[10, 20, 50, 100].map((pageSize) => (
                                        <SelectItem key={pageSize} value={`${pageSize}`} className="cursor-pointer">
                                            {pageSize}
                                        </SelectItem>
                                    ))}
                                    {table.getFilteredRowModel().rows.length > 0 && (
                                        <SelectItem key="all" value="All">All</SelectItem>
                                    )}
                                </SelectContent>
                            </Select>
                        </div>
                        <div className="flex items-center space-x-2">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            onClick={() => table.previousPage()}
                                            disabled={!table.getCanPreviousPage() || isTableLoading || processing}
                                        >
                                            <ArrowLeft className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>Previous Page</TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            onClick={() => table.nextPage()}
                                            disabled={!table.getCanNextPage() || isTableLoading || processing}
                                        >
                                            <ArrowRight className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>Next Page</TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                        <div className="text-muted-foreground text-sm">
                            {isTableLoading ? (
                                <Skeleton className="h-4 w-24" />
                            ) : (
                                `Page ${table.getState().pagination.pageIndex + 1} of ${table.getPageCount()}`
                            )}
                        </div>
                        <div className="flex items-center gap-2">
                            {isTableLoading ? (
                                <Skeleton className="h-4 w-32" />
                            ) : (
                                <span className="text-sm font-medium">
                  {`${table.getFilteredRowModel().rows.length} filtered out of ${enrollments.length} enrollments`}
                </span>
                            )}
                        </div>
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger asChild>
                                    <Link href="/enrollments/create">
                                        <Button size="sm" disabled={isTableLoading || processing}>
                                            <Plus className="h-4 w-4" />
                                        </Button>
                                    </Link>
                                </TooltipTrigger>
                                <TooltipContent>Add a new enrollment</TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                        <DropdownMenu>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="outline" disabled={isTableLoading || processing}>
                                                Columns <ChevronDown className="ml-2 h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>Click to Show or Hide Specific Columns</TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <DropdownMenuContent align="end">
                                {table
                                    .getAllColumns()
                                    .filter((column) => column.getCanHide())
                                    .map((column) => (
                                        <DropdownMenuCheckboxItem
                                            key={column.id}
                                            className="capitalize"
                                            checked={column.getIsVisible()}
                                            onCheckedChange={(value) => column.toggleVisibility(!!value)}
                                            disabled={isTableLoading || processing}
                                        >
                                            {column.id.replace(/\./g, ' ')}
                                        </DropdownMenuCheckboxItem>
                                    ))}
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>
                <div className="rounded-md border">
                    <Table>
                        <TableHeader>
                            {table.getHeaderGroups().map((headerGroup) => (
                                <TableRow key={headerGroup.id}>
                                    {headerGroup.headers.map((header) => (
                                        <TableHead key={header.id}>
                                            {header.isPlaceholder ? null : flexRender(header.column.columnDef.header, header.getContext())}
                                        </TableHead>
                                    ))}
                                </TableRow>
                            ))}
                        </TableHeader>
                        <TableBody>
                            {isTableLoading ? (
                                Array.from({ length: table.getState().pagination.pageSize }).map((_, index) => (
                                    <TableRow key={index}>
                                        {columns.map((_, colIndex) => (
                                            <TableCell key={colIndex}>
                                                <Skeleton className="h-4 w-full" />
                                            </TableCell>
                                        ))}
                                    </TableRow>
                                ))
                            ) : table.getRowModel().rows?.length ? (
                                table.getRowModel().rows.map((row) => (
                                    <TableRow key={row.id} data-state={row.getIsSelected() && "selected"}>
                                        {row.getVisibleCells().map((cell) => (
                                            <TableCell key={cell.id}>
                                                {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                            </TableCell>
                                        ))}
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell colSpan={columns.length} className="h-24 text-center">
                                        No results.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
                <AlertDialog open={!!enrollmentToDelete} onOpenChange={(openState) => !openState && setEnrollmentToDelete(null)}>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                            <AlertDialogDescription>
                                This action cannot be undone. This will permanently delete the enrollment for{" "}
                                <strong>
                                    {enrollmentToDelete?.student ? `${enrollmentToDelete.student.first_name} ${enrollmentToDelete.student.last_name}` : 'this student'}
                                </strong> in <strong>{enrollmentToDelete?.course?.name || 'this course'}</strong>.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel onClick={() => setEnrollmentToDelete(null)}>
                                Cancel
                            </AlertDialogCancel>
                            <AlertDialogAction onClick={confirmDelete} disabled={processing}>
                                Continue
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </AppLayout>
    );
}

export default Index;
