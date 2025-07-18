import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, LayoutGrid ,BookUser,User,Users,Trophy,Contact,Book,ListOrdered,Calendar } from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Students',
        href: '/students',
        icon: BookUser,
    },
    // {
    //     title: 'Schedules',
    //     href: '/schedules',
    //     icon: Calendar,
    // },
    {
        title: 'Courses',
        href: '/courses',
        icon: Book,
    },
    {
        title: 'Enrollment',
        href: '/enrollments',
        icon: ListOrdered,
    },
    {
        title: 'Teachers',
        href: '/teachers',
        icon: Contact,
    },
    {
        title: 'User',
        href: '/users',
        icon: User,
    },
    {
        title: 'Teams',
        href: '/teams',
        icon: Users,
    },
    {
        title: 'Competitions',
        href: '/competitions',
        icon: Trophy,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
