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
        title: 'Edit a Category',
        href: '/categories/edit',
    },
];

interface Category {
    id: number;
    name: string;
    description: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    category: Category;
}

export default function EditCategory({ category }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: category.name,
        description: category.description,
    });

    const handleUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('categories.update', category.id), {
            onSuccess: () => {
                console.log('Category updated');
            },
            onError: () => {
                console.log('Update failed');
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit Category" />
            <div className="p-4 sm:p-6 lg:p-8 xl:p-10">
                <Link href={route('categories.index')}>
                    <Button className="mb-4">Back to Categories</Button>
                </Link>

                <div className="mx-auto max-w-2xl rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 md:max-w-3xl lg:max-w-4xl lg:p-8 xl:max-w-5xl 2xl:max-w-6xl">
                    <h2 className="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Category</h2>

                    {Object.keys(errors).length > 0 && (
                        <Alert variant="destructive" className="mb-6">
                            <AlertCircleIcon className="h-4 w-4" />
                            <AlertTitle>Validation Error</AlertTitle>
                            <AlertDescription>
                                <ul className="list-disc list-inside">
                                    {Object.entries(errors).map(([key, message]) => (
                                        <li key={key}>{message as string}</li>
                                    ))}
                                </ul>
                            </AlertDescription>
                        </Alert>
                    )}

                    <form className="space-y-6" onSubmit={handleUpdate}>
                        {/* Category Name */}
                        <div>
                            <Label htmlFor="name" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category Name
                            </Label>
                            <Input
                                id="name"
                                name="name"
                                type="text"
                                placeholder="Enter category name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"
                            />
                            {errors.name && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.name}</div>}
                        </div>

                        {/* Description */}
                        {/*<div>*/}
                        {/*    <Label htmlFor="description" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">*/}
                        {/*        Description*/}
                        {/*    </Label>*/}
                        {/*    <Textarea*/}
                        {/*        id="description"*/}
                        {/*        name="description"*/}
                        {/*        rows={4}*/}
                        {/*        placeholder="Enter category description"*/}
                        {/*        value={data.description}*/}
                        {/*        onChange={(e) => setData('description', e.target.value)}*/}
                        {/*        className="w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400"*/}
                        {/*    />*/}
                        {/*    {errors.description && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.description}</div>}*/}
                        {/*</div>*/}

                        {/* Submit */}
                        <Button type="submit" disabled={processing} className="mt-4 w-full sm:w-auto">
                            {processing ? 'Updating...' : 'Update Category'}
                        </Button>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
