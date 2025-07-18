import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { CheckCircle2Icon, ArrowLeft } from "lucide-react";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import AppLayout from "@/layouts/app-layout";
import { type BreadcrumbItem } from "@/types";

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Courses", href: "/courses" },
    { title: "Create", href: "/courses/create" },
];

interface TenantOption {
    id: number;
    name: string;
}

interface TeacherOption {
    id: number;
    first_name: string;
    last_name: string;
}

interface SubjectOption {
    id: number;
    name: string;
}

interface PageProps {
    flash: {
        message?: string;
        errors?: Record<string, string>;
    };
    availableTenants: TenantOption[];
    availableTeachers: TeacherOption[];
    availableSubjects: SubjectOption[];
    isNormalAdmin: boolean;
}

function Create() {
    const { flash, availableTenants, availableTeachers, availableSubjects, isNormalAdmin } = usePage<PageProps>().props;
    const { data, setData, post, processing, errors } = useForm({
        tenant_id: "",
        teacher_id: "",
        subject_id: "",
        name: "",
        description: "",
        level: "",
    });
    const [showAlert, setShowAlert] = useState(!!flash.message);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("courses.store"), {
            onSuccess: () => {
                setShowAlert(true);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Course" />
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
                        <Button onClick={() => setShowAlert(false)} className="text-sm font-medium cursor-pointer" disabled={processing}>
                            ×
                        </Button>
                    </Alert>
                )}

                <Card>
                    <CardHeader>
                        <CardTitle>Create New Course</CardTitle>
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
                                <Label htmlFor="teacher_id">Teacher</Label>
                                <Select
                                    value={data.teacher_id}
                                    onValueChange={(value) => setData("teacher_id", value)}
                                    disabled={processing}
                                >
                                    <SelectTrigger id="teacher_id">
                                        <SelectValue placeholder="Select a teacher" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {availableTeachers.map((teacher) => (
                                            <SelectItem key={teacher.id} value={teacher.id.toString()}>
                                                {teacher.first_name} {teacher.last_name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.teacher_id && (
                                    <p className="text-sm text-red-600">{errors.teacher_id}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="subject_id">Subject</Label>
                                <Select
                                    value={data.subject_id}
                                    onValueChange={(value) => setData("subject_id", value)}
                                    disabled={processing}
                                >
                                    <SelectTrigger id="subject_id">
                                        <SelectValue placeholder="Select a subject" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {availableSubjects.map((subject) => (
                                            <SelectItem key={subject.id} value={subject.id.toString()}>
                                                {subject.name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                {errors.subject_id && (
                                    <p className="text-sm text-red-600">{errors.subject_id}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="name">Course Name</Label>
                                <Input
                                    id="name"
                                    value={data.name}
                                    onChange={(e) => setData("name", e.target.value)}
                                    disabled={processing}
                                    placeholder="Enter course name"
                                />
                                {errors.name && (
                                    <p className="text-sm text-red-600">{errors.name}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="description">Description</Label>
                                <Textarea
                                    id="description"
                                    value={data.description}
                                    onChange={(e) => setData("description", e.target.value)}
                                    disabled={processing}
                                    placeholder="Enter course description"
                                />
                                {errors.description && (
                                    <p className="text-sm text-red-600">{errors.description}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="level">Level</Label>
                                <Select
                                    value={data.level}
                                    onValueChange={(value) => setData("level", value)}
                                    disabled={processing}
                                >
                                    <SelectTrigger id="level">
                                        <SelectValue placeholder="Select a level" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="123">123</SelectItem>
                                        <SelectItem value="go">GO</SelectItem>
                                        <SelectItem value="iq">IQ</SelectItem>
                                        <SelectItem value="exp">EXP</SelectItem>
                                    </SelectContent>
                                </Select>
                                {errors.level && (
                                    <p className="text-sm text-red-600">{errors.level}</p>
                                )}
                            </div>

                            <div className="flex justify-end gap-2">
                                <Link href={route("courses.index")}>
                                    <Button variant="outline" disabled={processing}>
                                        <ArrowLeft className="mr-2 h-4 w-4" />
                                        Back
                                    </Button>
                                </Link>
                                <Button type="submit" disabled={processing}>
                                    Create Course
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
