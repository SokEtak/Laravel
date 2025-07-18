import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { PencilIcon, TrashIcon } from 'lucide-react';
import React from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product Detail',
        href: '/products',
    },
];

interface PageProps {
    flash: {
        message?: string;
    };
    product: Product;
}

interface Product {
    id: number;
    name: string;
    price: number;
    stock: number;
    description: string;
    created_at: string;
    updated_at: string;
}

export default function ProductDetail() {
    const { product } = usePage().props as PageProps;
    const { delete: destroy, processing } = useForm();

    const handleDelete = () => {
        if (confirm(`Are you sure you want to delete "${product.name}"?`)) {
            destroy(route('products.destroy', product.id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Product - ${product.name}`} />
            <div className="p-4 sm:p-6 lg:p-8 xl:p-10">
                <div className="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 h-100">
                    <div className="flex items-center justify-between mb-6">
                        <h2 className="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {product.name}
                        </h2>
                        <div className="flex gap-2">
                            <Link href={route('products.edit', product.id)}>
                                <Button variant="outline" size="sm">
                                    <PencilIcon className="mr-2 h-4 w-4" />
                                    Edit
                                </Button>
                            </Link>
                            <Button
                                variant="destructive"
                                size="sm"
                                onClick={handleDelete}
                                disabled={processing}
                            >
                                <TrashIcon className="mr-2 h-4 w-4" />
                                Delete
                            </Button>
                        </div>
                    </div>

                    <div className="space-y-5 text-gray-700 dark:text-gray-300 text-lg">
                        <div>
                            <span className="font-semibold text-gray-900 dark:text-gray-100">ID:</span>{' '}
                            {product.id}
                        </div>

                        <div>
                            <span className="font-semibold text-gray-900 dark:text-gray-100">Price:</span>{' '}
                            ${product.price}
                        </div>
                        <div>
                            <span className="font-semibold text-gray-900 dark:text-gray-100">Stock:</span>{' '}
                            {product.stock}
                        </div>
                        <div>
                            <span className="font-semibold text-gray-900 dark:text-gray-100">Description:</span>
                            <p className="mt-1 whitespace-pre-wrap break-words">{product.description}</p>
                        </div>
                        <div>
                            <span className="font-semibold text-gray-900 dark:text-gray-100">Created At:</span>{' '}
                            {new Date(product.created_at).toLocaleString()}
                        </div>
                        <div>
                            <span className="font-semibold text-gray-900 dark:text-gray-100">Updated At:</span>{' '}
                            {new Date(product.updated_at).toLocaleString()}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
