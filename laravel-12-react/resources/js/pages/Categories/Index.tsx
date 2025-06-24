import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { CheckCircle2Icon } from 'lucide-react';
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
    id: number;
    name: string;
    price: number;
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
        if (flash.message) {
            setShowAlert(true);
        }
    }, [flash.message]);

    // Effect to detect screen size
    useEffect(() => {
        const checkScreenSize = () => {
            setIsSmallScreen(window.innerWidth < 768); // Example breakpoint for small screens
        };

        checkScreenSize(); // Initial check
        window.addEventListener('resize', checkScreenSize);

        return () => window.removeEventListener('resize', checkScreenSize);
    }, []);

    const handleCloseAlert = () => {
        setShowAlert(false);
    };

    const handleDelete = (id: number, name: string) => {
        if (confirm(`Are you sure you want to delete ${name}?`)) {
            destroy(route('products.destroy', id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="List Of Products" />
            <div className="p-4 sm:p-2"> {/* Adjust padding for small screens */}
                {showAlert && flash.message && (
                    <Alert className="flex items-start justify-between mb-4"> {/* Add margin bottom */}
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
                <Link href={'/products/create'}>
                    <Button className="w-full sm:w-auto mb-4">Create Product</Button> {/* Full width on small screens */}
                </Link>

                {isSmallScreen ? (
                    // Card View for Small Screens
                    <div className="grid grid-cols-1 gap-4">
                        {products.map((product) => (
                            <div key={product.id} className="border p-4 rounded-lg shadow-sm">
                                <h3 className="text-lg font-semibold">{product.name}</h3>
                                <p className="text-gray-700">${product.price}</p>
                                {product.description && <p className="text-gray-500 text-sm mt-2">{product.description}</p>}
                                <div className="mt-4 flex flex-wrap gap-2">
                                    <Link href={route('products.edit', product.id)}>
                                        <Button size="sm">Edit</Button>
                                    </Link>
                                    <Button
                                        variant="destructive"
                                        size="sm"
                                        disabled={processing}
                                        onClick={() => handleDelete(product.id, product.name)}
                                    >
                                        Delete
                                    </Button>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    // Table View for Larger Screens
                    <div className="overflow-x-auto"> {/* Enable horizontal scrolling for the table */}
                        <Table className="min-w-full"> {/* Ensure table takes minimum full width to enable scroll */}
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Price</TableHead>
                                    <TableHead className="hidden md:table-cell">Description</TableHead> {/* Hide on small/medium screens */}
                                    <TableHead className="hidden lg:table-cell">Created At</TableHead> {/* Hide on medium screens */}
                                    <TableHead className="hidden lg:table-cell">Updated At</TableHead> {/* Hide on medium screens */}
                                    <TableHead>Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {products.map((product) => (
                                    <TableRow key={product.id}>
                                        <TableCell>{product.name}</TableCell>
                                        <TableCell>${product.price}</TableCell>
                                        <TableCell className="hidden md:table-cell">{product.description}</TableCell>
                                        <TableCell className="hidden lg:table-cell">{new Date(product.created_at).toLocaleString('en-US', { timeZone: 'Asia/Phnom_Penh' })}</TableCell>
                                        <TableCell className="hidden lg:table-cell">{new Date(product.updated_at).toLocaleString('en-US', { timeZone: 'Asia/Phnom_Penh' })}</TableCell>
                                        <TableCell>
                                            <div className="flex flex-wrap gap-2"> {/* Use flexbox for actions */}
                                                <Link href={route('products.edit', product.id)}>
                                                    <Button size="sm">Edit</Button> {/* Smaller buttons */}
                                                </Link>
                                                <Button
                                                    size="sm"
                                                    variant="destructive"
                                                    disabled={processing}
                                                    onClick={() => handleDelete(product.id, product.name)}
                                                >
                                                    Delete
                                                </Button>
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
