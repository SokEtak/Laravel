import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { ArrowLeft, PencilIcon } from "lucide-react";
import { Head, Link, usePage } from "@inertiajs/react";
import AppLayout from "@/layouts/app-layout";
import { type BreadcrumbItem } from "@/types";

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Teachers", href: "/teachers" },
    { title: "View", href: null },
];

interface Teacher {
    id: number;
    tenant_id: number;
    subject_id: number;
    first_name: string;
    last_name: string;
    gender: string;
    dob: string;
    address: string;
    hire_date: string;
    tenant?: { id: number; name: string };
    subject?: { id: number; name: string };
}

interface PageProps {
    teacher: Teacher;
    isNormalAdmin: boolean;
}

function Show() {
    const { teacher, isNormalAdmin } = usePage<PageProps>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Teacher: ${teacher.first_name} ${teacher.last_name}`} />
            <div className="p-4 sm:p-6 lg:p-5 xl:p-2">
                <Card>
                    <CardHeader>
                        <CardTitle>Teacher Details</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {!isNormalAdmin && teacher.tenant && (
                                <div>
                                    <h3 className="text-sm font-medium">Tenant</h3>
                                    <p className="text-sm text-gray-500">{teacher.tenant.name}</p>
                                </div>
                            )}
                            <div>
                                <h3 className="text-sm font-medium">Subject</h3>
                                <p className="text-sm text-gray-500">{teacher.subject?.name || 'N/A'}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">First Name</h3>
                                <p className="text-sm text-gray-500">{teacher.first_name}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Last Name</h3>
                                <p className="text-sm text-gray-500">{teacher.last_name}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Gender</h3>
                                <p className="text-sm text-gray-500 capitalize">{teacher.gender}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Date of Birth</h3>
                                <p className="text-sm text-gray-500">
                                    {teacher.dob ? new Date(teacher.dob).toLocaleDateString('en-US') : 'N/A'}
                                </p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Address</h3>
                                <p className="text-sm text-gray-500">{teacher.address || 'N/A'}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Hire Date</h3>
                                <p className="text-sm text-gray-500">
                                    {teacher.hire_date ? new Date(teacher.hire_date).toLocaleDateString('en-US') : 'N/A'}
                                </p>
                            </div>
                            <div className="flex justify-end gap-2">
                                <Link href={route("teachers.index")}>
                                    <Button variant="outline">
                                        <ArrowLeft className="mr-2 h-4 w-4" />
                                        Back
                                    </Button>
                                </Link>
                                <Link href={route("teachers.edit", teacher.id)}>
                                    <Button>
                                        <PencilIcon className="mr-2 h-4 w-4" />
                                        Edit
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

export default Show;
