import { Button } from '@/components/ui/button';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip'; // Import Tooltip components
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

interface Category {
    id: number;
    name: string;
}

interface ProductOption {
    id: number;
    name: string;
    value: string;
}

interface Discount {
    id: number;
    amount: number;
    expires_at: string;
}

interface Review {
    id: number;
    rating: number;
    comment: string;
}

interface Product {
    id: number;
    name: string;
    price: number;
    stock: number;
    description: string;
    created_at: string;
    updated_at: string;
    categories?: Category[];
    product_options?: ProductOption[];
    discounts?: Discount[];
    reviews?: Review[];
}

interface PageProps {
    product: Product;
}

export default function Show() {
    const { product } = usePage<PageProps>().props;
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
                <div className="mx-auto w-full max-w-7xl rounded-2xl border border-gray-200 bg-white p-10 shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <div className="flex items-center justify-between mb-6">
                        <h2 className="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {product.name}
                        </h2>
                        <div className="flex gap-2">
                            {/* Tooltip for Edit Button */}
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Link href={route('products.edit', product.id)}>
                                            <Button variant="outline" size="sm" className="cursor-pointer">
                                                <PencilIcon className="h-4 w-4" />
                                            </Button>
                                        </Link>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p>Edit Product</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>

                            {/* Tooltip for Delete Button */}
                            <TooltipProvider>
                                <Tooltip>
                                    <TooltipTrigger asChild>
                                        <Button
                                            variant="destructive"
                                            size="sm"
                                            onClick={handleDelete}
                                            disabled={processing}
                                            className="cursor-pointer"
                                        >
                                            <TrashIcon className="h-4 w-4" />
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>
                                        <p>Delete Product</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </div>
                    </div>

                    <div className="space-y-5 text-gray-700 dark:text-gray-300 text-lg">
                        <div>
                            <span className="font-semibold">ID:</span> {product.id}
                        </div>
                        <div>
                            <span className="font-semibold">Price:</span> ${product.price}
                        </div>
                        <div>
                            <span className="font-semibold">Stock:</span> {product.stock}
                        </div>
                        <div>
                            <span className="font-semibold">Description:</span>
                            <p className="mt-1 whitespace-pre-wrap break-words">{product.description}</p>
                        </div>
                        <div>
                            <span className="font-semibold">Created At:</span>{' '}
                            {new Date(product.created_at).toLocaleString()}
                        </div>
                        <div>
                            <span className="font-semibold">Updated At:</span>{' '}
                            {new Date(product.updated_at).toLocaleString()}
                        </div>

                        {/* Categories */}
                        {product.categories && (
                            <div>
                                <span className="font-semibold">Categories:</span>
                                <ul className="list-disc ml-5">
                                    {product.categories.map((cat) => (
                                        <li key={cat.id}>{cat.name}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        {/* Product Options */}
                        {product.product_options && (
                            <div>
                                <span className="font-semibold">Options:</span>
                                <ul className="list-disc ml-5">
                                    {product.product_options.map((opt) => (
                                        <li key={opt.id}>
                                            {opt.name}: {opt.value}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        {/* Discounts */}
                        {product.discounts && (
                            <div>
                                <span className="font-semibold">Discounts:</span>
                                {product.discounts.length === 0 ? (
                                    <p>No discounts available.</p>
                                ) : (
                                    <ul className="list-disc ml-5">
                                        {product.discounts.map((d) => (
                                            <li key={d.id}>
                                                ${d.amount} off until{' '}
                                                {new Date(d.expires_at).toLocaleDateString()}
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </div>
                        )}

                        {/* Reviews */}
                        {product.reviews && (
                            <div>
                                <span className="font-semibold">Reviews:</span>
                                {product.reviews.length === 0 ? (
                                    <p>No reviews yet.</p>
                                ) : (
                                    <ul className="space-y-2">
                                        {product.reviews.map((r) => (
                                            <li key={r.id} className="border rounded p-2">
                                                <strong>Rating:</strong> {r.rating} <br />
                                                <strong>Comment:</strong> {r.comment}
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
