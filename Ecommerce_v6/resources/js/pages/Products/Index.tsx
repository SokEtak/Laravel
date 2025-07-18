import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
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
import { CheckCircle2Icon, EyeIcon, PencilIcon, TrashIcon, Plus } from 'lucide-react';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product',
        href: '/products',
    },
];

interface PageProps {
    flash: {
        message?: string;
    };
    products: Product[];
}

interface Product {
    category_id: number;
    id: number;
    name: string;
    price: number;
    stock: number;
    description: string;
    created_at: string;
    updated_at: string;
}

export default function Index() {
    const { flash, products } = usePage().props as PageProps;
    const [showAlert, setShowAlert] = useState(false);
    const { processing, delete: destroy } = useForm();
    const [isSmallScreen, setIsSmallScreen] = useState(false);

    useEffect(() => {
        if (flash.message) setShowAlert(true);
    }, [flash.message]);

    useEffect(() => {
        const checkScreenSize = () => setIsSmallScreen(window.innerWidth < 768);
        checkScreenSize();
        window.addEventListener('resize', checkScreenSize);
        return () => window.removeEventListener('resize', checkScreenSize);
    }, []);

    const handleCloseAlert = () => setShowAlert(false);

    const handleDelete = (id: number, name: string) => {
        if (confirm(`Are you sure you want to delete ${name}?`)) {
            destroy(route('products.destroy', id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="List Of Products" />
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
                        <Button onClick={handleCloseAlert} className="text-sm font-medium cursor-pointer">
                            &times;
                        </Button>
                    </Alert>
                )}

                <TooltipProvider>
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <Link href={'/products/create'}>
                                <Button className="mb-4 w-full sm:w-auto cursor-pointer" size="sm">
                                    <Plus className="h-4 w-4" />
                                    {/*Create Product*/}
                                </Button>
                            </Link>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Create a new product</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>

                {isSmallScreen ? (
                    <div className="grid grid-cols-1 gap-4">
                        {products.map((product) => (
                            <div key={product.id} className="rounded-lg border p-4 shadow-sm">
                                <h3 className="text-lg font-semibold">{product.name}</h3>
                                <p className="text-sm text-gray-600">${product.price}</p>
                                <p className="mt-2 text-sm text-gray-500">Stock: {product.stock}</p>
                                <p className="mt-2 text-sm text-gray-500">Created: {new Date(product.created_at).toLocaleString()}</p>
                                <p className="mt-2 text-sm text-gray-500">Updated: {new Date(product.updated_at).toLocaleString()}</p>
                                <div className="mt-4 flex flex-wrap gap-2">
                                    <TooltipProvider>
                                        <Tooltip>
                                            <TooltipTrigger asChild>
                                                <Link href={route('products.show', product.id)}>
                                                    <Button size="icon" variant="outline" className="cursor-pointer">
                                                        <EyeIcon className="h-4 w-4" />
                                                    </Button>
                                                </Link>
                                            </TooltipTrigger>
                                            <TooltipContent>Show</TooltipContent>
                                        </Tooltip>
                                        <Tooltip>
                                            <TooltipTrigger asChild>
                                                <Link href={route('products.edit', product.id)}>
                                                    <Button size="icon" className="cursor-pointer">
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
                                                    onClick={() => handleDelete(product.id, product.name)}
                                                    className="cursor-pointer"
                                                >
                                                    <TrashIcon className="h-4 w-4" />
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>Delete</TooltipContent>
                                        </Tooltip>
                                    </TooltipProvider>
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
                                    <TableHead>Price</TableHead>
                                    <TableHead className="hidden md:table-cell">Stock</TableHead>
                                    <TableHead>Created At</TableHead>
                                    <TableHead>Updated At</TableHead>
                                    <TableHead>Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {products.map((product) => (
                                    <TableRow key={product.id}>
                                        <TableCell>{product.name}</TableCell>
                                        <TableCell>${product.price}</TableCell>
                                        <TableCell className="hidden md:table-cell">{product.stock}</TableCell>
                                        <TableCell>{new Date(product.created_at).toLocaleString()}</TableCell>
                                        <TableCell>{new Date(product.updated_at).toLocaleString()}</TableCell>
                                        <TableCell>
                                            <div className="flex flex-wrap gap-2">
                                                <TooltipProvider>
                                                    <Tooltip>
                                                        <TooltipTrigger asChild>
                                                            <Link href={route('products.show', product.id)}>
                                                                <Button size="icon" variant="outline" className="cursor-pointer">
                                                                    <EyeIcon className="h-4 w-4" />
                                                                </Button>
                                                            </Link>
                                                        </TooltipTrigger>
                                                        <TooltipContent>Show</TooltipContent>
                                                    </Tooltip>
                                                    <Tooltip>
                                                        <TooltipTrigger asChild>
                                                            <Link href={route('products.edit', product.id)}>
                                                                <Button size="icon" className="cursor-pointer">
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
                                                                onClick={() => handleDelete(product.id, product.name)}
                                                                className="cursor-pointer"
                                                            >
                                                                <TrashIcon className="h-4 w-4" />
                                                            </Button>
                                                        </TooltipTrigger>
                                                        <TooltipContent>Delete</TooltipContent>
                                                    </Tooltip>
                                                </TooltipProvider>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
