import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader, SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem }
    from '@/components/ui/sidebar';

import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import {
    LayoutGrid,
    PackageSearch ,
    Tags,
    User,
    CreditCard,
    ShoppingCart,
    TicketPercent,
    Store,
}
    from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Products',
        href: '/products',
        icon: PackageSearch,
    },
    {
        title: 'Categories',
        href: '/categories',
        icon: Tags,
    },
    {
        title: 'Users',
        href: '/users',
        icon: User,
    },
    {
        title: 'Payments',
        href: '/payments',
        icon: CreditCard,
    },
    {
        title: 'Orders',
        href: '/orders',
        icon: ShoppingCart,
    },
    {
        title: 'Discounts',
        href: '/discounts',
        icon: TicketPercent,
    },
    {
        title: 'Stores',
        href: '/stores',
        icon: Store,
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Repository',
    //     href: 'https://github.com/laravel/react-starter-kit',
    //     icon: Folder,
    // },
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
