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
        title: 'Create Category',
        href: '/categories/create',
    },
];

export default function CreateCategory() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        description: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('categories.store'), {
            onSuccess: () => console.log('Category created successfully'),
            onError: (errors) => console.log(errors),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create New Category" />
            <div className="p-4 sm:p-6 lg:p-8 xl:p-10">
                <Link href={route('categories.index')}>
                    <Button className="mb-4">Back to Categories</Button>
                </Link>

                <div className="mx-auto max-w-2xl rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 md:max-w-3xl lg:max-w-4xl">
                    <h2 className="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">Create New Category</h2>

                    {Object.keys(errors).length > 0 && (
                        <Alert variant="destructive" className="mb-6">
                            <AlertCircleIcon className="h-4 w-4" />
                            <AlertTitle>Error Submitting Form</AlertTitle>
                            <AlertDescription>
                                <ul className="list-disc list-inside">
                                    {Object.entries(errors).map(([field, message]) => (
                                        <li key={field}>{message as string}</li>
                                    ))}
                                </ul>
                            </AlertDescription>
                        </Alert>
                    )}

                    <form className="space-y-6" onSubmit={handleSubmit}>
                        {/* Name Field */}
                        <div>
                            <Label htmlFor="name" className="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category Name
                            </Label>
                            <Input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="e.g., Electronics"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full border-gray-300 bg-white text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                            />
                            {errors.name && <div className="mt-2 text-sm text-red-600 dark:text-red-400">{errors.name}</div>}
                        </div>

                        {/* Submit Button */}
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Creating...' : 'Create Category'}
                        </Button>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
