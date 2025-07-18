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
import { AlertCircleIcon , ArrowLeft } from 'lucide-react';
import React from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create a Product',
        href: '/products/create',
    },
];

interface Category {
    id: number;
    name: string;
    description: string;
}

interface PageProps {
    categories: Category[];
}

export default function Create() {
    const { categories } = usePage<PageProps>().props;

    const { data, setData, post, processing, errors } = useForm({
        name: '',
        price: '',
        stock: '',
        category_id: '',
        description: '',
    });

    const inputClass =
        "w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100";

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('products.store'), {
            onSuccess: () => {
                console.log('Product created successfully!');
            },
            onError: (errs) => {
                console.error('Submission errors:', errs);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create New Product" />
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

                <div className="mx-auto max-w-4xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 className="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">
                        Create New Product
                    </h2>

                    {Object.keys(errors).length > 0 && (
                        <Alert variant="destructive" className="mb-6">
                            <AlertCircleIcon className="h-4 w-4" />
                            <AlertTitle>Submission Errors</AlertTitle>
                            <AlertDescription>
                                <ul className="list-inside list-disc">
                                    {Object.entries(errors).map(([field, message]) => (
                                        <li key={field}>{message as string}</li>
                                    ))}
                                </ul>
                            </AlertDescription>
                        </Alert>
                    )}

                    <form className="space-y-6" onSubmit={handleSubmit}>
                        {/* Product Name */}
                        <div>
                            <Label htmlFor="name">Product Name</Label>
                            <Input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="e.g., Electronics"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className={inputClass}
                                required
                            />
                            {errors.name && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.name}</p>
                            )}
                        </div>

                        {/* Price */}
                        <div>
                            <Label htmlFor="price">Price ($)</Label>
                            <Input
                                type="number"
                                id="price"
                                name="price"
                                step="0.01"
                                min="0"
                                placeholder="e.g., 19.99"
                                value={data.price}
                                onChange={(e) => setData('price', e.target.value)}
                                className={inputClass}
                                required
                            />
                            {errors.price && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.price}</p>
                            )}
                        </div>

                        {/* Stock */}
                        <div>
                            <Label htmlFor="stock">Stock</Label>
                            <Input
                                type="number"
                                id="stock"
                                name="stock"
                                step="1"
                                min="0"
                                placeholder="e.g., 100"
                                value={data.stock}
                                onChange={(e) => setData('stock', e.target.value)}
                                className={inputClass}
                                required
                            />
                            {errors.stock && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.stock}</p>
                            )}
                        </div>

                        {/* Category Selection */}
                        <div>
                            <Label htmlFor="category_id">Category</Label>
                            <select
                                id="category_id"
                                name="category_id"
                                value={data.category_id}
                                onChange={(e) => setData('category_id', e.target.value)}
                                required
                                className={`${inputClass} rounded-md h-10 px-2`}
                            >
                                <option value="">Select a category</option>
                                {categories.map((category) => (
                                    <option key={category.id} value={category.id}>
                                        {category.name}
                                    </option>
                                ))}
                            </select>
                            {errors.category_id && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.category_id}</p>
                            )}
                        </div>

                        {/* Description */}
                        <div>
                            <Label htmlFor="description">Product Description</Label>
                            <Textarea
                                id="description"
                                name="description"
                                rows={6}
                                placeholder="Tell us more about the product..."
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className={inputClass + " rounded-md"}
                            />
                            {errors.description && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.description}</p>
                            )}
                        </div>

                        {/* Submit Button */}
                        <TooltipProvider>
                            <Tooltip>
                                <TooltipTrigger asChild>
                                    <Button type="submit" disabled={processing} className="cursor-pointer">
                                        {processing ? 'Creating...' : 'Create Product'}
                                    </Button>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p>Click to create the new product.</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
