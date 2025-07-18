import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { ArrowLeft, PencilIcon } from "lucide-react";
import { Head, Link, usePage } from "@inertiajs/react";
import AppLayout from "@/layouts/app-layout";
import { type BreadcrumbItem } from "@/types";

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Courses", href: "/courses" },
    { title: "Detail", href: null },
];

interface Course {
    id: number;
    tenant_id: number;
    teacher_id: number;
    subject_id: number;
    name: string;
    description: string;
    level: string;
    tenant?: { id: number; name: string };
    teacher?: { id: number; first_name: string; last_name: string };
    subject?: { id: number; name: string };
}

interface PageProps {
    course: Course;
    isNormalAdmin: boolean;
}

function Show() {
    const { course, isNormalAdmin } = usePage<PageProps>().props;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Course: ${course.name}`} />
            <div className="p-4 sm:p-6 lg:p-5 xl:p-2">
                <Card>
                    <CardHeader>
                        <CardTitle>Course Details</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-4">
                            {!isNormalAdmin && course.tenant && (
                                <div>
                                    <h3 className="text-sm font-medium">Tenant</h3>
                                    <p className="text-sm text-gray-500">{course.tenant.name}</p>
                                </div>
                            )}
                            <div>
                                <h3 className="text-sm font-medium">Teacher</h3>
                                <p className="text-sm text-gray-500">
                                    {course.teacher ? `${course.teacher.first_name} ${course.teacher.last_name}` : 'N/A'}
                                </p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Subject</h3>
                                <p className="text-sm text-gray-500">{course.subject?.name || 'N/A'}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Course Name</h3>
                                <p className="text-sm text-gray-500">{course.name}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Description</h3>
                                <p className="text-sm text-gray-500">{course.description || 'N/A'}</p>
                            </div>
                            <div>
                                <h3 className="text-sm font-medium">Level</h3>
                                <p className="text-sm text-gray-500 capitalize">{course.level}</p>
                            </div>
                            <div className="flex justify-end gap-2">
                                <Link href={route("courses.index")}>
                                    <Button variant="outline">
                                        <ArrowLeft className="mr-2 h-4 w-4" />
                                        Back
                                    </Button>
                                </Link>
                                <Link href={route("courses.edit", course.id)}>
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
