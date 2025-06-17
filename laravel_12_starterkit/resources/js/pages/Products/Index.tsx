import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Product',
        href: 'products',
    },
];

export default function Index() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Product List" />
            <div>
                <h1>index page</h1>
                <Link
                    href={route('products.create')}
                    className="inline-block px-4 py-2 bg-green-600 text-white font-medium rounded-md border border-green-700 hover:bg-green-700 transition"
                >
                    Create New Product
                </Link>
            </div>
        </AppLayout>
    );
}
