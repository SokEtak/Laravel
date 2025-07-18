import { Head, Link, usePage } from "@inertiajs/react";
import AppLayout from "@/layouts/app-layout";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { ArrowLeft, PencilIcon } from "lucide-react";
import { type BreadcrumbItem } from "@/types";
import { format, parseISO } from "date-fns";

interface Student {
    id: number;
    tenant_id: number;
    first_name: string;
    last_name: string;
    gender: string;
    grade: string;
    dob: string;
    tenant?: { id: number; name: string };
}

interface PageProps {
    student: Student;
    isSuperAdmin: boolean;
    auth: {
        user: {
            id: number;
            name: string;
            role_id: number;
        };
    };
}

const breadcrumbs: (student: Student) => BreadcrumbItem[] = (student) => [
    { title: "Students", href: "/students" },
    { title: `${student.first_name} ${student.last_name}`, href: null },
];

function Show() {
    const { student, isSuperAdmin } = usePage<PageProps>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs(student)}>
            <Head title={`Student: ${student.first_name} ${student.last_name}`} />
            <div className="p-4 sm:p-6 lg:p-5 xl:p-2">
                <Card>
                    <CardHeader>
                        <CardTitle>
                            {student.first_name} {student.last_name}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            <div>
                                <h3 className="text-sm font-medium">ID</h3>
                                <p className="text-sm text-gray-500">{student.id}</p>
                            </div>
                            {isSuperAdmin && student.tenant && (
                                <div>
                                    <h3 className="text-sm font-medium">Tenant</h3>
                                    <p className="text-sm text-gray-500">{student.tenant.name}</p>
                                </div>
                            )}
                            <div>
                                <h3 className="text-sm font-medium">Gender</h3>
                                <p className="text-sm text-gray-500 capitalize">{student.gender || "N/A"}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Grade</h3>
                                <p className="text-sm text-gray-500">{student.grade || "N/A"}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Date of Birth</h3>
                                <p className="text-sm text-gray-500">
                                    {student.dob ? format(parseISO(student.dob), "PPP") : "N/A"}
                                </p>
                            </div>
                            <div className="flex justify-end gap-2">
                                <Link href={route("students.index")}>
                                    <Button variant="outline">
                                        <ArrowLeft className="mr-2 h-4 w-4" />
                                        Back
                                    </Button>
                                </Link>
                                <Link href={route("students.edit", student.id)}>
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
