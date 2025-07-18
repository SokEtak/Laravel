//npm install react-beautiful-dnd --legacy-peer-deps //command to install drag and drop

import {
    UserRound, Briefcase, BookOpen, CalendarCheck2, Users, Trophy, Group, User2, ListOrdered, ClipboardList
} from "lucide-react";
import AppLayout from '@/layouts/app-layout';
import { Head, usePage } from '@inertiajs/react';
import { useState } from 'react';
import { DragDropContext, Droppable, Draggable, DropResult } from 'react-beautiful-dnd';
import type { BreadcrumbItem } from '@/types';

function StatCard({ icon: Icon, count, label, iconColor, bgColor, darkBg }: {
    icon: React.ComponentType<any>;
    count: string | number;
    label: string;
    iconColor: string;
    bgColor: string;
    darkBg: string;
}) {
    return (
        <div className="bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 p-6 flex flex-col items-center text-center cursor-grab select-none">
            <div className={`flex items-center justify-center w-14 h-14 rounded-full ${bgColor} ${darkBg} ${iconColor} mb-4`}>
                <Icon className="w-7 h-7" />
            </div>
            <h3 className="text-3xl font-bold text-gray-900 dark:text-white">{count}</h3>
            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">{label}</p>
        </div>
    );
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Dashboard",
        href: "/dashboards",
    },
];

export default function Dashboard() {
    const user = usePage().props.auth.user;

    // Stat cards data as state so we can reorder it
    const [stats, setStats] = useState([
        { id: 'students', icon: UserRound, count: '1,200', label: 'Total Students', iconColor: 'text-blue-600', bgColor: 'bg-blue-50', darkBg: 'dark:bg-blue-900/50' },
        { id: 'courses', icon: BookOpen, count: '75', label: 'Total Courses', iconColor: 'text-green-600', bgColor: 'bg-green-50', darkBg: 'dark:bg-green-900/50' },
        { id: 'teachers', icon: Briefcase, count: '50', label: 'Total Teachers', iconColor: 'text-purple-600', bgColor: 'bg-purple-50', darkBg: 'dark:bg-purple-900/50' },
        { id: 'active-classes', icon: CalendarCheck2, count: '30', label: 'Active Classes Today', iconColor: 'text-orange-600', bgColor: 'bg-orange-50', darkBg: 'dark:bg-orange-900/50' },
        { id: 'classes', icon: ClipboardList, count: '25', label: 'Total Classes', iconColor: 'text-indigo-600', bgColor: 'bg-indigo-50', darkBg: 'dark:bg-indigo-900/50' },
        { id: 'competitions', icon: Trophy, count: '5', label: 'Competitions', iconColor: 'text-yellow-600', bgColor: 'bg-yellow-50', darkBg: 'dark:bg-yellow-900/50' },
        { id: 'teams', icon: Group, count: '10', label: 'Teams', iconColor: 'text-pink-600', bgColor: 'bg-pink-50', darkBg: 'dark:bg-pink-900/50' },
        { id: 'team-members', icon: User2, count: '20', label: 'Team Members', iconColor: 'text-cyan-600', bgColor: 'bg-cyan-50', darkBg: 'dark:bg-cyan-900/50' },
        { id: 'subjects', icon: ListOrdered, count: '12', label: 'Subjects', iconColor: 'text-lime-600', bgColor: 'bg-lime-50', darkBg: 'dark:bg-lime-900/50' },
        { id: 'competition-results', icon: Users, count: '8', label: 'Competition Results', iconColor: 'text-rose-600', bgColor: 'bg-rose-50', darkBg: 'dark:bg-rose-900/50' },
    ]);

    if (!user || user.role_id !== 1) {
        return (
            <AppLayout breadcrumbs={breadcrumbs}>
                <Head title="Access Denied" />
                <div className="p-10 text-center text-red-600 text-xl">
                    Access Denied. You do not have permission to view this page.
                </div>
            </AppLayout>
        );
    }

    const recentEnrollments = [
        { id: 1, name: 'Alice Smith', course: 'Advanced Algebra', date: '2025-07-10' },
        { id: 2, name: 'Bob Johnson', course: 'World History II', date: '2025-07-09' },
        { id: 3, name: 'Charlie Brown', course: 'Introduction to Physics', date: '2025-07-09' },
        { id: 4, name: 'Diana Miller', course: 'English Literature', date: '2025-07-08' },
        { id: 5, name: 'Eve Davis', course: 'Computer Science Basics', date: '2025-07-07' },
    ];

    // Handle drag end - reorder the stats array
    function onDragEnd(result: DropResult) {
        if (!result.destination) return;
        const reordered = Array.from(stats);
        const [removed] = reordered.splice(result.source.index, 1);
        reordered.splice(result.destination.index, 0, removed);
        setStats(reordered);
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 p-6 overflow-x-auto bg-gray-50 dark:bg-gray-950 rounded-xl shadow-inner">

                {/* Draggable Stats Grid */}
                <DragDropContext onDragEnd={onDragEnd}>
                    <Droppable direction="horizontal" droppableId="stats" type="STATCARDS">
                        {(provided) => (
                            <div
                                {...provided.droppableProps}
                                ref={provided.innerRef}
                                className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                            >
                                {stats.map(({ id, icon, count, label, iconColor, bgColor, darkBg }, index) => (
                                    <Draggable key={id} draggableId={id} index={index}>
                                        {(providedDrag) => (
                                            <div
                                                ref={providedDrag.innerRef}
                                                {...providedDrag.draggableProps}
                                                {...providedDrag.dragHandleProps}
                                            >
                                                <StatCard
                                                    icon={icon}
                                                    count={count}
                                                    label={label}
                                                    iconColor={iconColor}
                                                    bgColor={bgColor}
                                                    darkBg={darkBg}
                                                />
                                            </div>
                                        )}
                                    </Draggable>
                                ))}
                                {provided.placeholder}
                            </div>
                        )}
                    </Droppable>
                </DragDropContext>

                {/* Recent Enrollment Table */}
                <div className="flex-1 min-h-[500px] bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 relative overflow-hidden">
                    <h2 className="text-xl font-semibold text-gray-800 dark:text-white mb-4">Recent Enrollments</h2>
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead className="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student Name</th>
                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Course Enrolled</th>
                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Enrollment Date</th>
                            </tr>
                            </thead>
                            <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            {recentEnrollments.map(({ id, name, course, date }) => (
                                <tr key={id} className="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{name}</td>
                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{course}</td>
                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{date}</td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
