import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { CheckCircle2Icon, ArrowLeft } from "lucide-react";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import AppLayout from "@/layouts/app-layout";
import { type BreadcrumbItem } from "@/types";

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Enrollments", href: "/enrollments" },
    { title: "Create", href: "/enrollments/create" },
];

interface TenantOption {
    id: number;
    name: string;
}

interface StudentOption {
    id: number;
    first_name: string;
    last_name: string;
}

interface CourseOption {
    id: number;
    name: string;
}

interface PageProps {
    flash: {
        message?: string;
        errors?: Record<string, string>;
    };
    availableTenants: TenantOption[];
    availableStudents: StudentOption[];
    availableCourses: CourseOption[];
    isNormalAdmin: boolean;
}

function Create() {
    const { flash, availableTenants, availableStudents, availableCourses, isNormalAdmin } = usePage<PageProps>().props;
    const { data, setData, post, processing, errors } = useForm({
        tenant_id: "",
        student_id: "",
        course_id: "",
        fee: "",
    });
    const [showAlert, setShowAlert] = useState(!!flash.message);
    const [showIframe, setShowIframe] = useState(false);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("enrollments.store"), {
            onSuccess: () => {
                setShowAlert(true);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Enrollment" />
            <div className="p-4 sm:p-6 lg:p-5 xl:p-2">
                {showAlert && flash.message && (
                    <Alert className="mb-4 flex items-start justify-between">
                        <div className="flex gap-2">
                            <CheckCircle2Icon className="h-4 w-4" />
                            <div>
                                <AlertTitle>Success</AlertTitle>
                                <AlertDescription>{flash.message}</AlertDescription>
                            </div>
                        </div>
                        <Button
                            onClick={() => setShowAlert(false)}
                            className="text-sm font-medium cursor-pointer"
                            disabled={processing}
                        >
                            ×
                        </Button>
                    </Alert>
                )}

                <Card>
                    <CardHeader>
                        <CardTitle>Create New Enrollment</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSubmit} className="space-y-4">
                            {!isNormalAdmin && (
                                <div className="space-y-2">
                                    <Label htmlFor="tenant_id">Tenant</Label>
                                    <Select
                                        value={data.tenant_id}
                                        onValueChange={(value) => setData("tenant_id", value)}
                                        disabled={processing}
                                    >
                                        <SelectTrigger id="tenant_id">
                                            <SelectValue placeholder="Select a tenant" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {availableTenants.map((tenant) => (
                                                <SelectItem key={tenant.id} value={tenant.id.toString()}>
                                                    {tenant.name}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                    {errors.tenant_id && (
                                        <p className="text-sm text-red-600">{errors.tenant_id}</p>
                                    )}
                                </div>
                            )}

                            <div className="space-y-2">
                                <Label htmlFor="student_id">Student</Label>
                                <Select
                                    value={data.student_id}
                                    onValueChange={(value) => setData("student_id", value)}
                                    disabled={processing}
                                >
                                    <SelectTrigger id="student_id">
                                        <SelectValue placeholder="Select a student" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {availableStudents.map((student) => (
                                            <SelectItem key={student.id} value={student.id.toString()}>
                                                {student.first_name} {student.last_name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.student_id && (
                                    <p className="text-sm text-red-600">{errors.student_id}</p>
                                )}
                                <div className="text-sm">
                                    <span
                                        onClick={() => setShowIframe(true)}
                                        className="text-blue-600 hover:underline cursor-pointer"
                                    >
                                        User not exist? Click here
                                    </span>
                                </div>
                            </div>

                            {showIframe && (
                                <div className="space-y-2">
                                    <div className="flex justify-between items-center">
                                        <Label>Create New Student</Label>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            onClick={() => setShowIframe(false)}
                                            disabled={processing}
                                        >
                                            Close
                                        </Button>
                                    </div>
                                    <iframe
                                        src="../students/create"
                                        className="w-full h-[600px] border rounded-md"
                                        title="Create Student"
                                    />
                                </div>
                            )}

                            <div className="space-y-2">
                                <Label htmlFor="course_id">Course</Label>
                                <Select
                                    value={data.course_id}
                                    onValueChange={(value) => setData("course_id", value)}
                                    disabled={processing}
                                >
                                    <SelectTrigger id="course_id">
                                        <SelectValue placeholder="Select a course" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {availableCourses.map((course) => (
                                            <SelectItem key={course.id} value={course.id.toString()}>
                                                {course.name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.course_id && (
                                    <p className="text-sm text-red-600">{errors.course_id}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="fee">Fee</Label>
                                <Input
                                    id="fee"
                                    type="number"
                                    value={data.fee}
                                    onChange={(e) => setData("fee", e.target.value)}
                                    disabled={processing}
                                    placeholder="Enter fee amount"
                                    step="0.01"
                                />
                                {errors.fee && (
                                    <p className="text-sm text-red-600">{errors.fee}</p>
                                )}
                            </div>

                            <div className="flex justify-end gap-2">
                                <Link href={route("enrollments.index")}>
                                    <Button variant="outline" disabled={processing}>
                                        <ArrowLeft className="mr-2 h-4 w-4" />
                                        Back
                                    </Button>
                                </Link>
                                <Button type="submit" disabled={processing}>
                                    Create Enrollment
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
export default Create;
