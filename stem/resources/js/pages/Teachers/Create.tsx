import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { CalendarIcon, CheckCircle2Icon, ArrowLeft } from "lucide-react";
import { Head, Link, useForm, usePage } from "@inertiajs/react";
import AppLayout from "@/layouts/app-layout";
import { format } from "date-fns";
import { type BreadcrumbItem } from "@/types";

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Teachers", href: "/teachers" },
    { title: "Create", href: "/teachers/create" },
];

interface TenantOption {
    id: number;
    name: string;
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
    availableSubjects: SubjectOption[];
    isNormalAdmin: boolean;
}

function Create() {
    const { flash, availableTenants, availableSubjects, isNormalAdmin } = usePage<PageProps>().props;
    const { data, setData, post, processing, errors } = useForm({
        tenant_id: "",
        subject_id: "",
        first_name: "",
        last_name: "",
        gender: "",
        dob: "",
        address: "",
        hire_date: "",
    });
    const [showAlert, setShowAlert] = useState(!!flash.message);
    const [isDobCalendarOpen, setIsDobCalendarOpen] = useState(false);
    const [isHireDateCalendarOpen, setIsHireDateCalendarOpen] = useState(false);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route("teachers.store"), {
            onSuccess: () => {
                setShowAlert(true);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Teacher" />
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
                        <CardTitle>Create New Teacher</CardTitle>
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
                                <Label htmlFor="first_name">First Name</Label>
                                <Input
                                    id="first_name"
                                    value={data.first_name}
                                    onChange={(e) => setData("first_name", e.target.value)}
                                    disabled={processing}
                                    placeholder="Enter first name"
                                />
                                {errors.first_name && (
                                    <p className="text-sm text-red-600">{errors.first_name}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="last_name">Last Name</Label>
                                <Input
                                    id="last_name"
                                    value={data.last_name}
                                    onChange={(e) => setData("last_name", e.target.value)}
                                    disabled={processing}
                                    placeholder="Enter last name"
                                />
                                {errors.last_name && (
                                    <p className="text-sm text-red-600">{errors.last_name}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="gender">Gender</Label>
                                <Select
                                    value={data.gender}
                                    onValueChange={(value) => setData("gender", value)}
                                    disabled={processing}
                                >
                                    <SelectTrigger id="gender">
                                        <SelectValue placeholder="Select a gender" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="male">Male</SelectItem>
                                        <SelectItem value="female">Female</SelectItem>
                                    </SelectContent>
                                </Select>
                                {errors.gender && (
                                    <p className="text-sm text-red-600">{errors.gender}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="dob">Date of Birth</Label>
                                <Popover open={isDobCalendarOpen} onOpenChange={setIsDobCalendarOpen}>
                                    <PopoverTrigger asChild>
                                        <div className="relative">
                                            <Input
                                                id="dob"
                                                value={data.dob ? format(new Date(data.dob), "PPP") : ""}
                                                placeholder="Pick a date"
                                                readOnly
                                                disabled={processing}
                                                className="pr-10"
                                                onClick={() => setIsDobCalendarOpen(true)}
                                            />
                                            <CalendarIcon className="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                        </div>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-auto p-0">
                                        <Calendar
                                            mode="single"
                                            selected={data.dob ? new Date(data.dob) : undefined}
                                            onSelect={(date) => {
                                                setData("dob", date ? format(date, "yyyy-MM-dd") : "");
                                                setIsDobCalendarOpen(false);
                                            }}
                                            disabled={processing}
                                            initialFocus
                                            captionLayout="dropdown"
                                        />
                                    </PopoverContent>
                                </Popover>
                                {errors.dob && (
                                    <p className="text-sm text-red-600">{errors.dob}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="address">Address</Label>
                                <Textarea
                                    id="address"
                                    value={data.address}
                                    onChange={(e) => setData("address", e.target.value)}
                                    disabled={processing}
                                    placeholder="Enter address"
                                />
                                {errors.address && (
                                    <p className="text-sm text-red-600">{errors.address}</p>
                                )}
                            </div>

                            <div className="space-y-2">
                                <Label htmlFor="hire_date">Hire Date</Label>
                                <Popover open={isHireDateCalendarOpen} onOpenChange={setIsHireDateCalendarOpen}>
                                    <PopoverTrigger asChild>
                                        <div className="relative">
                                            <Input
                                                id="hire_date"
                                                value={data.hire_date ? format(new Date(data.hire_date), "PPP") : ""}
                                                placeholder="Pick a date"
                                                readOnly
                                                disabled={processing}
                                                className="pr-10"
                                                onClick={() => setIsHireDateCalendarOpen(true)}
                                            />
                                            <CalendarIcon className="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
                                        </div>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-auto p-0">
                                        <Calendar
                                            mode="single"
                                            selected={data.hire_date ? new Date(data.hire_date) : undefined}
                                            onSelect={(date) => {
                                                setData("hire_date", date ? format(date, "yyyy-MM-dd") : "");
                                                setIsHireDateCalendarOpen(false);
                                            }}
                                            disabled={processing}
                                            initialFocus
                                            captionLayout="dropdown"
                                        />
                                    </PopoverContent>
                                </Popover>
                                {errors.hire_date && (
                                    <p className="text-sm text-red-600">{errors.hire_date}</p>
                                )}
                            </div>

                            <div className="flex justify-end gap-2">
                                <Link href={route("teachers.index")}>
                                    <Button variant="outline" disabled={processing}>
                                        <ArrowLeft className="mr-2 h-4 w-4" />
                                        Back
                                    </Button>
                                </Link>
                                <Button type="submit" disabled={processing}>
                                    Create Teacher
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
