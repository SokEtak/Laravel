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
} from "@/components/ui/alert-dialog";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Input } from "@/components/ui/input";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/components/ui/tooltip";
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
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
    ChevronDown,
    MoreHorizontal,
    ArrowUp,
    ArrowDown,
    ArrowLeft,
    ArrowRight,
    Filter as FilterIcon,
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
    SortingState,
} from "@tanstack/react-table";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Teachers",
        href: "/teachers",
    },
];

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

interface SubjectOption {
    id: number;
    name: string;
}

interface PageProps {
    flash: {
        message?: string;
    };
    teachers: Teacher[];
    availableTenants: TenantOption[];
    availableSubjects: SubjectOption[];
    isSuperAdmin: boolean;
    auth: {
        user: AuthUser;
    };
}

interface Teacher {
    id: number;
    first_name: string;
    last_name: string;
    gender: string;
    hire_date: string;
    subject_id: number;
    tenant_id: number;
    created_at: string;
    updated_at: string;
    tenant?: {
        id: number;
        name: string;
    };
    subject?: {
        id: number;
        name: string;
    };
}

const getColumns = (
    setTeacherToDelete: React.Dispatch<React.SetStateAction<Teacher | null>>,
    processing: boolean,
    isSuperAdmin: boolean,
    availableSubjects: SubjectOption[],
    availableYears: string[],
    availableTenants: TenantOption[]
): ColumnDef<Teacher>[] => {
    const columns: ColumnDef<Teacher>[] = [
        {
            accessorKey: "id",
            header: ({ column }) => (
                <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                    ID
                    {{ asc: <ArrowUp className="ml-2 h-4 w-4" />, desc: <ArrowDown className="ml-2 h-4 w-4" /> }[column.getIsSorted() as string] ?? <ArrowUpDown className="ml-2 h-4 w-4" />}
                </Button>
            ),
            cell: ({ row }) => <div className="px-3">{row.getValue("id")}</div>,
        },
        {
            accessorKey: "first_name",
            header: ({ column }) => (
                <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                    First Name
                    {{ asc: <ArrowUp className="ml-2 h-4 w-4" />, desc: <ArrowDown className="ml-2 h-4 w-4" /> }[column.getIsSorted() as string] ?? <ArrowUpDown className="ml-2 h-4 w-4" />}
                </Button>
            ),
            cell: ({ row }) => <div className="px-3">{row.getValue("first_name")}</div>,
        },
        {
            accessorKey: "last_name",
            header: ({ column }) => (
                <Button variant="ghost" onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}>
                    Last Name
                    {{ asc: <ArrowUp className="ml-2 h-4 w-4" />, desc: <ArrowDown className="ml-2 h-4 w-4" /> }[column.getIsSorted() as string] ?? <ArrowUpDown className="ml-2 h-4 w-4" />}
                </Button>
            ),
            cell: ({ row }) => <div className="px-3">{row.getValue("last_name")}</div>,
        },
        {
            accessorKey: "gender",
            header: ({ column }) => {
                const filterValue = (column.getFilterValue() || "") as string;
                const [isGenderDropdownOpen, setIsGenderDropdownOpen] = useState(false);

                return (
                    <div className="flex items-center space-x-2">
                        <span>Gender</span>
                        <DropdownMenu open={isGenderDropdownOpen} onOpenChange={setIsGenderDropdownOpen}>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                                <FilterIcon className={`h-4 w-4 ${filterValue ? 'text-blue-500' : 'text-gray-400'}`} />
                                                <span className="sr-only">Open filter menu</span>
                                            </Button>
                                        </DropdownMenuTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Filter Gender
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <DropdownMenuContent align="start" className="p-2 w-[180px]">
                                <Select
                                    value={filterValue}
                                    onValueChange={(value) => {
                                        column.setFilterValue(value === "All" ? "" : value);
                                        setIsGenderDropdownOpen(false);
                                    }}
                                >
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select Gender" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="All">All Genders</SelectItem>
                                        <SelectItem value="male">Male</SelectItem>
                                        <SelectItem value="female">Female</SelectItem>
                                    </SelectContent>
                                </Select>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                );
            },
            cell: ({ row }) => <div className="px-3 capitalize">{row.getValue("gender")}</div>,
            filterFn: "equals",
            enableSorting: false,
        },
        {
            accessorKey: "subject.name",
            header: ({ column }) => {
                const filterValue = (column.getFilterValue() || "") as string;
                const [isSubjectDropdownOpen, setIsSubjectDropdownOpen] = useState(false);

                return (
                    <div className="flex items-center space-x-2">
                        <span>Subject</span>
                        <DropdownMenu open={isSubjectDropdownOpen} onOpenChange={setIsSubjectDropdownOpen}>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                                <FilterIcon className={`h-4 w-4 ${filterValue ? 'text-blue-500' : 'text-gray-400'}`} />
                                                <span className="sr-only">Open filter menu</span>
                                            </Button>
                                        </DropdownMenuTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Filter by Subject
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <DropdownMenuContent align="start" className="p-2 w-[180px]">
                                <Select
                                    value={filterValue}
                                    onValueChange={(value) => {
                                        column.setFilterValue(value === "All" ? "" : value);
                                        setIsSubjectDropdownOpen(false);
                                    }}
                                >
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select Subject" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="All">All Subjects</SelectItem>
                                        {availableSubjects.map(subject => (
                                            <SelectItem key={subject.id} value={subject.name}>{subject.name}</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                );
            },
            cell: ({ row }) => <div className="px-2">{row.original.subject?.name || 'N/A'}</div>,
            filterFn: (row, columnId, filterValue) => {
                const subjectName = row.original.subject?.name?.toLowerCase() || '';
                return subjectName.includes(String(filterValue).toLowerCase());
            },
            enableSorting: false,
        },
        {
            accessorKey: "hire_date",
            header: ({ column }) => {
                const filterValue = (column.getFilterValue() || "") as string;
                const [isHireDateDropdownOpen, setIsHireDateDropdownOpen] = useState(false);

                return (
                    <div className="flex items-center space-x-2">
                        <span>Hire Date</span>
                        <DropdownMenu open={isHireDateDropdownOpen} onOpenChange={setIsHireDateDropdownOpen}>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                                <FilterIcon className={`h-4 w-4 ${filterValue ? 'text-blue-500' : 'text-gray-400'}`} />
                                                <span className="sr-only">Open filter menu</span>
                                            </Button>
                                        </DropdownMenuTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Filter by Hire Year
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <DropdownMenuContent align="start" className="p-2 w-[180px]">
                                <Select
                                    value={filterValue}
                                    onValueChange={(value) => {
                                        column.setFilterValue(value === "All" ? "" : value);
                                        setIsHireDateDropdownOpen(false);
                                    }}
                                >
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select Year" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="All">All Years</SelectItem>
                                        {availableYears.map(year => (
                                            <SelectItem key={year} value={year}>{year}</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                );
            },
            cell: ({ row }) => {
                const date = new Date(row.getValue("hire_date"));
                return <div className="px-2">{date.toLocaleDateString('en-US')}</div>;
            },
            filterFn: (row, columnId, filterValue) => {
                const filterYearString = String(filterValue);
                if (filterYearString === "" || filterYearString === "All") {
                    return true;
                }
                const hireDate = row.original.hire_date;
                if (!hireDate) {
                    return false;
                }
                const year = new Date(hireDate).getFullYear().toString();
                return year === filterYearString;
            },
            enableSorting: true,
        },
    ];

    if (isSuperAdmin) {
        columns.push({
            accessorKey: "tenant.name",
            header: ({ column }) => {
                const filterValue = (column.getFilterValue() || "") as string;
                const [isTenantDropdownOpen, setIsTenantDropdownOpen] = useState(false);

                return (
                    <div className="flex items-center space-x-2">
                        <span>Tenant Name</span>
                        <DropdownMenu open={isTenantDropdownOpen} onOpenChange={setIsTenantDropdownOpen}>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="ghost" size="sm" className="h-8 w-8 p-0 data-[state=open]:bg-accent">
                                                <FilterIcon className={`h-4 w-4 ${filterValue ? 'text-blue-500' : 'text-gray-400'}`} />
                                                <span className="sr-only">Open filter menu</span>
                                            </Button>
                                        </DropdownMenuTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Filter by Tenant
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <DropdownMenuContent align="start" className="p-2 w-[180px]">
                                <Select
                                    value={filterValue}
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
                                            <SelectItem key={tenant.id} value={tenant.name}>{tenant.name}</SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                );
            },
            cell: ({ row }) => <div className="px-3 capitalize">{row.original.tenant?.name || 'N/A'}</div>,
            filterFn: (row, columnId, filterValue) => {
                const tenantName = row.original.tenant?.name?.toLowerCase() || '';
                return tenantName.includes(String(filterValue).toLowerCase());
            },
            enableSorting: true,
        });
    }

    columns.push({
        id: "actions",
        enableHiding: false,
        enableGlobalFilter: false,
        enableSorting: false,
        cell: ({ row }) => {
            const teacher = row.original;
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
                                <Link href={route("teachers.show", teacher.id)}>
                                    <Tooltip>
                                        <TooltipTrigger asChild>
                                            <Button variant="ghost" className="h-4 w-4 p-0 cursor-pointer">
                                                <EyeIcon className="h-4 w-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent side="right" align="center">
                                            View
                                        </TooltipContent>
                                    </Tooltip>
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem asChild className="p-1">
                                <Link href={route("teachers.edit", teacher.id)}>
                                    <Tooltip>
                                        <TooltipTrigger asChild>
                                            <Button variant="ghost" className="h-4 w-4 p-0 cursor-pointer">
                                                <PencilIcon className="h-4 w-4" />
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent side="right" align="center">
                                            Edit
                                        </TooltipContent>
                                    </Tooltip>
                                </Link>
                            </DropdownMenuItem>
                            <DropdownMenuItem
                                onClick={() => setTeacherToDelete(teacher)}
                                className="text-red-600 p-1"
                                disabled={processing}
                            >
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button variant="ghost" className="h-4 w-4 p-0 cursor-pointer">
                                            <TrashIcon className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent side="right" align="center">
                                        Delete
                                    </TooltipContent>
                                </Tooltip>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </TooltipProvider>
            );
        },
    });

    return columns;
};

function Index() {
    const { flash, teachers, isSuperAdmin, availableSubjects, availableTenants } = usePage<PageProps>().props;
    const [showAlert, setShowAlert] = useState(false);
    const { processing, delete: destroy } = useForm();
    const [teacherToDelete, setTeacherToDelete] = useState<Teacher | null>(null);
    const [isTableLoading, setIsTableLoading] = useState(true);

    const availableYears = useMemo(() => {
        const years = new Set<string>();
        teachers.forEach(teacher => {
            if (teacher.hire_date) {
                const date = new Date(teacher.hire_date);
                if (isNaN(date.getTime())) {
                    console.warn("Invalid hire_date for teacher:", teacher, "Hire Date:", teacher.hire_date);
                } else {
                    const year = date.getFullYear().toString();
                    years.add(year);
                }
            }
        });
        return Array.from(years).sort((a, b) => parseInt(b) - parseInt(a));
    }, [teachers]);

    const [sorting, setSorting] = useState<SortingState>([]);
    const [columnFilters, setColumnFilters] = useState<ColumnFiltersState>([]);
    const [columnVisibility, setColumnVisibility] = useState<VisibilityState>({});
    const [rowSelection, setRowSelection] = useState({});
    const [pagination, setPagination] = useState<PaginationState>({
        pageIndex: 0,
        pageSize: 10,
    });
    const [globalFilter, setGlobalFilter] = useState('');

    const columns = useMemo(() => getColumns(
        setTeacherToDelete,
        processing,
        isSuperAdmin,
        availableSubjects,
        availableYears,
        availableTenants
    ), [setTeacherToDelete, processing, isSuperAdmin, availableSubjects, availableYears, availableTenants]);

    const table = useReactTable({
        data: teachers,
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
            const firstName = String(row.original.first_name).toLowerCase();
            const lastName = String(row.original.last_name).toLowerCase();
            return firstName.includes(search) || lastName.includes(search);
        },
        state: {
            sorting,
            columnFilters,
            columnVisibility,
            rowSelection,
            pagination,
            globalFilter,
        },
        initialState: {
            pagination: {
                pageSize: 10,
            },
            columnVisibility: {
                'tenant.name': isSuperAdmin,
            },
        },
    });

    useEffect(() => {
        if (flash.message) setShowAlert(true);
        const timer = setTimeout(() => {
            setIsTableLoading(false);
        }, 500);
        return () => clearTimeout(timer);
    }, [flash.message, teachers]);

    const handleCloseAlert = () => setShowAlert(false);

    const confirmDelete = () => {
        if (teacherToDelete) {
            destroy(route("teachers.destroy", teacherToDelete.id), {
                onSuccess: () => {
                    setTeacherToDelete(null);
                },
                onError: () => {
                    setTeacherToDelete(null);
                },
            });
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="List of Teachers" />
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
                                    if (value === "All") {
                                        table.setPageSize(table.getFilteredRowModel().rows.length);
                                    } else {
                                        table.setPageSize(Number(value));
                                    }
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
                                        <SelectItem key="all" value="All">
                                            All
                                        </SelectItem>
                                    )}
                                </SelectContent>
                            </Select>
                        </div>

                        <div className="flex items-center space-x-2">
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button
                                            className="cursor-pointer"
                                            variant="outline"
                                            size="sm"
                                            onClick={() => table.previousPage()}
                                            disabled={!table.getCanPreviousPage() || isTableLoading || processing}
                                        >
                                            <ArrowLeft className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Previous Page
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button
                                            className="cursor-pointer"
                                            variant="outline"
                                            size="sm"
                                            onClick={() => table.nextPage()}
                                            disabled={!table.getCanNextPage() || isTableLoading || processing}
                                        >
                                            <ArrowRight className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Next Page
                                    </TooltipContent>
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
                                    {`${table.getFilteredRowModel().rows.length} filtered out of ${teachers.length} teachers`}
                                </span>
                            )}
                        </div>

                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger asChild>
                                    <Link href="/teachers/create">
                                        <Button className="cursor-pointer" size="sm" disabled={isTableLoading || processing}>
                                            <Plus className="h-4 w-4" />
                                        </Button>
                                    </Link>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p>Add a new teacher</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>

                        <DropdownMenu>
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger>
                                        <DropdownMenuTrigger asChild>
                                            <Button variant="outline" className="cursor-pointer" disabled={isTableLoading || processing}>
                                                Columns <ChevronDown className="ml-2 h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        Click to Show or Hide Specific Columns
                                    </TooltipContent>
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
                                            {column.id.replace(/_/g, ' ')}
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
                                            {header.isPlaceholder
                                                ? null
                                                : flexRender(header.column.columnDef.header, header.getContext())}
                                        </TableHead>
                                    ))}
                                </TableRow>
                            ))}
                        </TableHeader>
                        {isTableLoading ? (
                            <TableBody>
                                {Array.from({ length: table.getState().pagination.pageSize }).map((_, index) => (
                                    <TableRow key={index}>
                                        {columns.map((_, colIndex) => (
                                            <TableCell key={colIndex}>
                                                <Skeleton className="h-4 w-full" />
                                            </TableCell>
                                        ))}
                                    </TableRow>
                                ))}
                            </TableBody>
                        ) : (
                            <TableBody>
                                {table.getRowModel().rows?.length ? (
                                    table.getRowModel().rows.map((row) => (
                                        <TableRow
                                            key={row.id}
                                            data-state={row.getIsSelected() && "selected"}
                                        >
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
                        )}
                    </Table>
                </div>

                <AlertDialog open={!!teacherToDelete} onOpenChange={(openState) => !openState && setTeacherToDelete(null)}>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                            <AlertDialogDescription>
                                This action cannot be undone. This will permanently delete{" "}
                                <strong>
                                    {teacherToDelete?.first_name} {teacherToDelete?.last_name}
                                </strong>.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel onClick={() => setTeacherToDelete(null)}>
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
