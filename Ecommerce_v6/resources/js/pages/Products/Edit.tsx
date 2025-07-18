import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { AlertCircleIcon, ArrowLeft } from 'lucide-react';
import React from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit a Product',
        href: '/products/edit',
    },
];

interface Category {
    id: number;
    name: string;
}

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
    stock: number;
    category_id: number; // Expect a single category_id
    created_at: string;
    updated_at: string;
}

interface PageProps {
    product: Product;
    categories: Category[];
    productCategories: number[];
}

export default function EditProduct() {
    const { product, categories } = usePage<PageProps>().props;

    const { data, setData, put, processing, errors } = useForm({
        name: product.name,
        price: product.price,
        description: product.description,
        stock: product.stock,
        category_id: product.category_id, // Initialize with the product's current category_id
    });

    const handleUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('products.update', product.id), {
            onSuccess: () => {
                console.log('Product updated');
            },
            onError: () => {
                console.log('Update failed');
            },
        });
    };

    const inputClass =
        "w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400";

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit Product" />
            <div className="p-4 sm:p-6 lg:p-8 xl:p-10">
                <TooltipProvider>
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <Link href={route('products.index')}>
                                <Button className="mb-4 flex items-center gap-2 cursor-pointer">
                                    <ArrowLeft className="h-4 w-4" />
                                    Back to Products
                                </Button>
                            </Link>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Go back to the list of products</p>
                        </TooltipContent>
                    </Tooltip>
                </TooltipProvider>

                <div className="mx-auto max-w-2xl rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6 md:max-w-3xl lg:max-w-4xl lg:p-8 xl:max-w-5xl 2xl:max-w-6xl dark:border-gray-700 dark:bg-gray-800">
                    <h2 className="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Product</h2>

                    {Object.keys(errors).length > 0 && (
                        <Alert variant="destructive" className="mb-6">
                            <AlertCircleIcon className="h-4 w-4" />
                            <AlertTitle>Validation Error</AlertTitle>
                            <AlertDescription>
                                <ul className="list-inside list-disc">
                                    {Object.entries(errors).map(([key, message]) => (
                                        <li key={key}>{message as string}</li>
                                    ))}
                                </ul>
                            </AlertDescription>
                        </Alert>
                    )}

                    <form className="space-y-6" onSubmit={handleUpdate}>
                        {/* Product Name */}
                        <div>
                            <Label htmlFor="name" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Name
                            </Label>
                            <Input
                                required={true}
                                id="name"
                                name="name"
                                type="text"
                                placeholder="Enter product name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className={inputClass}
                            />
                            {errors.name && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.name}</div>}
                        </div>

                        {/* Product Price */}
                        <div>
                            <Label htmlFor="price" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price ($)
                            </Label>
                            <Input
                                required={true}
                                id="price"
                                name="price"
                                type="number"
                                min="0"
                                step="0.01"
                                placeholder="Enter price"
                                value={data.price}
                                onChange={(e) => setData('price', Number(e.target.value))}
                                className={inputClass}
                            />
                            {errors.price && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.price}</div>}
                        </div>

                        {/* Product Stock */}
                        <div>
                            <Label htmlFor="stock" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Stock
                            </Label>
                            <Input
                                required={true}
                                id="stock"
                                name="stock"
                                type="number"
                                min="0"
                                placeholder="Enter stock quantity"
                                value={data.stock}
                                onChange={(e) => setData('stock', Number(e.target.value))}
                                className={inputClass}
                            />
                            {errors.stock && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.stock}</div>}
                        </div>

                        {/* Category Selection (Single-select) */}
                        <div>
                            <Label htmlFor="category_id" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category
                            </Label>
                            <select
                                id="category_id"
                                name="category_id"
                                value={data.category_id || ''} // Ensure it's a string for select value
                                onChange={(e) => setData('category_id', Number(e.target.value))}
                                required
                                className={`${inputClass} rounded-md h-10 px-2`}
                            >
                                <option value="">Select a category</option>
                                {categories.map((category: Category) => (
                                    <option key={category.id} value={category.id}>
                                        {category.name}
                                    </option>
                                ))}
                            </select>
                            {errors.category_id && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.category_id}</p>
                            )}
                        </div>

                        {/* Product Description */}
                        <div>
                            <Label htmlFor="description" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </Label>
                            <Textarea
                                id="description"
                                name="description"
                                rows={4}
                                placeholder="Enter product description"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className={inputClass + " rounded-md"}
                            />
                            {errors.description && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.description}</div>}
                        </div>

                        {/* Submit */}
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger asChild>
                                    <Button type="submit" disabled={processing} className="mt-4 w-full sm:w-auto cursor-pointer">
                                        {processing ? 'Updating...' : 'Update Product'}
                                    </Button>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p>Click to save your changes.</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
