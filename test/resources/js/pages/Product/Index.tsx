import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
interface PageProps{
    products: Product[];
}

interface Product{
    name:string,
    description:string
    price:number,
    created_at:string,
    updated_at:string
}



export default function Index() {
    const { products } = usePage().props as PageProps;
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            {products.map((product)=>(
            ))
            })
        </AppLayout>
    );
}
