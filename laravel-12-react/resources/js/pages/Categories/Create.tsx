import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { AlertCircleIcon } from 'lucide-react';
import React from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create a Product',
        href: '/products/create',
    },
];

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        price: '',
        description: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('products.store'), {
            onSuccess: () => {
                console.log('success');
            },
            onError: (errors) => {
                console.log(errors);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create New Product" />
            <div className="p-4 sm:p-6 lg:p-8 xl:p-10">
                {' '}
                {/* Responsive padding for overall layout */}
                <Link href={route('products.index')}>
                    <Button className="mb-4">Back to Products</Button>
                </Link>
                {/* Main form container with responsive max-widths */}
                {/* Adjusted background, border, text colors for better compatibility */}
                <div className="mx-auto max-w-2xl rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 md:max-w-3xl lg:max-w-4xl lg:p-8 xl:max-w-5xl 2xl:max-w-6xl">
                    <h2 className="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Create New Product</h2>

                    {/* Errors List */}
                    {Object.keys(errors).length > 0 && (
                        <Alert variant="destructive" className="mb-6">
                            <AlertCircleIcon className="h-4 w-4" />
                            <AlertTitle>Error Submitting Form</AlertTitle>
                            <AlertDescription>
                                <ul className="list-inside list-disc">
                                    {Object.entries(errors).map(([error, message]) => (
                                        <li key={error}>{message as string}</li>
                                    ))}
                                </ul>
                            </AlertDescription>
                        </Alert>
                    )}

                    <form className="space-y-6" onSubmit={handleSubmit}>
                        {/* Name Field */}
                        <div>
                            <Label htmlFor="name" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Name
                            </Label>
                            <Input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="e.g., Organic Honey 500g"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" // Enhanced input styles
                            />
                            {errors.name && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.name}</div>} {/* Dark mode red */}
                        </div>

                        {/* Price Field */}
                        <div>
                            <Label htmlFor="price" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price ($)
                            </Label>
                            <Input
                                type="number"
                                id="price"
                                name="price"
                                placeholder="e.g., 12.99"
                                min="0"
                                step="0.01"
                                value={data.price}
                                onChange={(e) => setData('price', e.target.value)}
                                className="w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" // Enhanced input styles
                            />
                            {errors.price && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.price}</div>}
                        </div>

                        {/* Description Field */}
                        <div>
                            <Label htmlFor="description" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Description
                            </Label>
                            <Textarea
                                id="description"
                                name="description"
                                placeholder="Tell us more about this product..."
                                rows={6}
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                className="w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" // Enhanced textarea styles
                            />
                            {errors.description && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.description}</div>}
                        </div>

                        {/* Submit Button */}
                        {/* Assuming your Button component itself handles dark mode or uses a primary color */}
                        <Button type="submit" disabled={processing} className="mt-4 w-full sm:w-auto">
                            {processing ? 'Creating...' : 'Create Product'}
                        </Button>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
