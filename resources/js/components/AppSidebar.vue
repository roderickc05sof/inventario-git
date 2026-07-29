<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { 
    Boxes, 
    Cpu, 
    Eye, 
    KeyRound, 
    ShieldCheck, 
    UserPlus, 
    Users,
    BookOpen,
    MapPin,
    Tags,
    Factory,
    Activity,
    ClipboardList
} from 'lucide-vue-next';
import { computed } from 'vue';

import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';

import type { NavItem as BaseNavItem } from '@/types/navigation';

interface NavItem extends BaseNavItem {
    items?: NavItem[];
}

const page = usePage();

const mainNavItems = computed<NavItem[]>(() => {
    const base: NavItem[] = [
        {
            title: 'Inventario',
            href: '/assets',
            icon: Boxes,
        },
        {
            title: 'Componentes',
            href: '/components',
            icon: Cpu,
        },
        {
            title: 'Asignaciones',
            href: '/assignments',
            icon: ClipboardList,
        },
        {
            title: 'Catálogos',
            href: '#',
            icon: BookOpen,
            items: [
                {
                    title: 'Ubicaciones',
                    href: '/locations',
                    icon: MapPin,
                },
                {
                    title: 'Categorías',
                    href: '/categories',
                    icon: Tags,
                },
                {
                    title: 'Fabricantes',
                    href: '/manufacturers',
                    icon: Factory,
                },
                {
                    title: 'Estados',
                    href: '/asset-statuses',
                    icon: Activity,
                },
            ]
        }
    ];

    const auth = (page.props as Record<string, any>)?.auth || {};
    const user = auth.user || {};

    const userRole = (
        typeof user.role === 'string' 
            ? user.role 
            : user.role?.descripcion || user.role?.nombre || ''
    ).toLowerCase();

    const isGroupAdmin = Number(user.id_role) === 1 || userRole.includes('admin');

    if (isGroupAdmin) {
        base.push({
            title: 'Administración',
            href: '#',
            icon: ShieldCheck,
            items: [
                {
                    title: 'Usuarios',
                    href: '/users',
                    icon: Users,
                },
                {
                    title: 'Crear Usuario',
                    href: '/users/create',
                    icon: UserPlus,
                },
                {
                    title: 'Gestión de Vistas',
                    href: '/vistas',
                    icon: Eye,
                },
                {
                    title: 'Permisos',
                    href: '/permisos',
                    icon: KeyRound,
                },
            ],
        });
    }

    return base;
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <div class="px-3 py-2 text-xs font-semibold text-muted-foreground uppercase tracking-wider group-data-[collapsible=icon]:hidden">
                Plataforma
            </div>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
</template>