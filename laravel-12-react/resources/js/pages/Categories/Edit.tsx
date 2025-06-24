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
        title: 'Edit a Product',
        href: '/products/edit',
    },
];

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    product: Product;
}

export default function Edit({product}: Props) {

    //use post for new data and put for updating
    const { data, setData, put , processing, errors } = useForm({
        name: product.name,
        price: product.price,
        description: product.description,
    });
    const handleUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('products.update', product.id), {
            onSuccess: ()=>{
                console.log('success');
            },
            onError: ()=>{
                console.log('error');
            }
        })
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit A Product" />
            <Link href={route('products.index')}>
                <Button>Back</Button>
            </Link>
            <div className="w-8/12 p-4">
                {/*Errors List*/}
                {Object.keys(errors).length > 0 && (
                    <Alert variant="destructive">
                        <AlertCircleIcon className="h-4 w-4" />
                        <AlertTitle>Error</AlertTitle>
                        <AlertDescription>
                            <ul className="list-inside list-disc">
                                {Object.entries(errors).map(([error, message]) => (
                                    <li key={error}>{message as string}</li>
                                ))}
                            </ul>
                        </AlertDescription>
                    </Alert>
                )}
                <form className="space-y-6" onSubmit={handleUpdate}>
                    <div className="mb-3">
                        <Label htmlFor="name">Name</Label>
                        <Input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter product name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                        {errors.name && <div className="text-sm text-red-500">{errors.name}</div>}
                    </div>

                    <div>
                        <Label htmlFor="price">Price</Label>
                        <Input
                            type="number"
                            id="price"
                            name="price"
                            placeholder="Enter product price"
                            min="0"
                            step="0.01"
                            value={data.price}
                            onChange={(e) => setData('price', Number(e.target.value))}
                        />
                        {errors.price && <div className="text-sm text-red-500">{errors.price}</div>}
                    </div>

                    <div className="mb-3">
                        <Label htmlFor="description">Description</Label>
                        <Textarea
                            id="description"
                            name="description"
                            placeholder="Enter product description"
                            rows={4}
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                        />
                        {errors.description && <div className="text-sm text-red-500">{errors.description}</div>}
                    </div>
                    <Button type="submit" disabled={processing}>
                        Update Product
                    </Button>
                </form>
            </div>
        </AppLayout>
    );
}
