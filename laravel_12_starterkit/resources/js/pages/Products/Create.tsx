import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product',
        href: '/products',
    },
];

export default function Create() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Product" />
            <div>create page</div>
            <Link
                href={route('products.index')}
                className="nline-block px-4 py-2 bg-green-600 text-white font-medium rounded-md border border-green-700 hover:bg-green-400 transition"
            >
                Back To List
            </Link>
        </AppLayout>
    );
}
