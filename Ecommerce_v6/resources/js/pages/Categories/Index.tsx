import {
    Alert,
    AlertDescription,
    AlertTitle,
} from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import {
    CheckCircle2Icon,
    PencilIcon,
    TrashIcon,
} from 'lucide-react';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category',
        href: '/categories',
    },
];

interface PageProps {
    flash: {
        message?: string;
    };
    categories: Category[];
}

interface Category {
    id: number;
    name: string;
    description: string;
    created_at: string;
    updated_at: string;
}

export default function Index() {
    const { flash, categories } = usePage().props as PageProps;
    const [showAlert, setShowAlert] = useState(false);
    const { processing, delete: destroy } = useForm();
    const [isSmallScreen, setIsSmallScreen] = useState(false);

    useEffect(() => {
        if (flash.message) {
            setShowAlert(true);
        }
    }, [flash.message]);

    useEffect(() => {
        const checkScreenSize = () => {
            setIsSmallScreen(window.innerWidth < 768);
        };

        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);

        return () => window.removeEventListener('resize', checkScreenSize);
    }, []);

    const handleCloseAlert = () => {
        setShowAlert(false);
    };

    const handleDelete = (id: number, name: string) => {
        if (confirm(`Are you sure you want to delete ${name}?`)) {
            destroy(route('categories.destroy', id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="List Of Categories" />
            <div className="p-4 sm:p-2">
                {showAlert && flash.message && (
                    <Alert className="mb-4 flex items-start justify-between">
                        <div className="flex gap-2">
                            <CheckCircle2Icon className="h-4 w-4" />
                            <div>
                                <AlertTitle>New Notification</AlertTitle>
                                <AlertDescription>{flash.message}</AlertDescription>
                            </div>
                        </div>
                        <Button onClick={handleCloseAlert} className="text-sm font-medium">
                            &times;
                        </Button>
                    </Alert>
                )}

                <Tooltip>
                    <TooltipTrigger asChild>
                        <Link href="/categories/create">
                            <Button className="mb-4 w-full sm:w-auto">Create Category</Button>
                        </Link>
                    </TooltipTrigger>
                    <TooltipContent>Add a new category</TooltipContent>
                </Tooltip>


                <TooltipProvider>
                    {isSmallScreen ? (
                        <div className="grid grid-cols-1 gap-4">
                            {categories.map((category) => (
                                <div key={category.id} className="rounded-lg border p-4 shadow-sm">
                                    <h3 className="text-lg font-semibold">{category.name}</h3>
                                    {category.description && (
                                        <p className="mt-2 text-sm text-gray-500">
                                            {category.description}
                                        </p>
                                    )}
                                    <div className="mt-4 flex flex-wrap gap-2">
                                        <Tooltip>
                                            <TooltipTrigger asChild>
                                                <Link href={route('categories.edit', category.id)}>
                                                    <Button size="icon" variant="outline">
                                                        <PencilIcon className="h-4 w-4" />
                                                    </Button>
                                                </Link>
                                            </TooltipTrigger>
                                            <TooltipContent>Edit</TooltipContent>
                                        </Tooltip>

                                        <Tooltip>
                                            <TooltipTrigger asChild>
                                                <Button
                                                    variant="destructive"
                                                    size="icon"
                                                    disabled={processing}
                                                    onClick={() =>
                                                        handleDelete(category.id, category.name)
                                                    }
                                                >
                                                    <TrashIcon className="h-4 w-4" />
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>Delete</TooltipContent>
                                        </Tooltip>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="overflow-x-auto">
                            <Table className="min-w-full">
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Name</TableHead>
                                        <TableHead className="hidden lg:table-cell">
                                            Created At
                                        </TableHead>
                                        <TableHead className="hidden lg:table-cell">
                                            Updated At
                                        </TableHead>
                                        <TableHead>Action</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    {categories.map((category) => (
                                        <TableRow key={category.id}>
                                            <TableCell>{category.name}</TableCell>
                                            <TableCell className="hidden lg:table-cell">
                                                {new Date(category.created_at).toLocaleString('en-US', {
                                                    timeZone: 'Asia/Phnom_Penh',
                                                })}
                                            </TableCell>
                                            <TableCell className="hidden lg:table-cell">
                                                {new Date(category.updated_at).toLocaleString('en-US', {
                                                    timeZone: 'Asia/Phnom_Penh',
                                                })}
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex gap-2">
                                                    <Tooltip>
                                                        <TooltipTrigger asChild>
                                                            <Link href={route('categories.edit', category.id)}>
                                                                <Button size="icon" variant="outline">
                                                                    <PencilIcon className="h-4 w-4" />
                                                                </Button>
                                                            </Link>
                                                        </TooltipTrigger>
                                                        <TooltipContent>Edit</TooltipContent>
                                                    </Tooltip>

                                                    <Tooltip>
                                                        <TooltipTrigger asChild>
                                                            <Button
                                                                size="icon"
                                                                variant="destructive"
                                                                disabled={processing}
                                                                onClick={() =>
                                                                    handleDelete(category.id, category.name)
                                                                }
                                                            >
                                                                <TrashIcon className="h-4 w-4" />
                                                            </Button>
                                                        </TooltipTrigger>
                                                        <TooltipContent>Delete</TooltipContent>
                                                    </Tooltip>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </div>
                    )}
                </TooltipProvider>
            </div>
        </AppLayout>
    );
}
