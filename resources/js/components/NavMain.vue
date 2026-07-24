<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

// Componentes de Collapsible (acordeón desplegable)
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';

// Componentes de Sidebar UI
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';

import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types/navigation';

// Extendemos la interfaz localmente por si la de types no tiene 'items'
interface CustomNavItem extends NavItem {
    items?: CustomNavItem[];
}

defineProps<{
    items: CustomNavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Plataforma</SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                
                <!-- CASO 1: Si tiene sub-ítems (se despliega) -->
                <Collapsible
                    v-if="item.items && item.items.length > 0"
                    as-child
                    :default-open="item.isActive"
                    class="group/collapsible"
                >
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title">
                                <component :is="item.icon" v-if="item.icon" />
                                <span>{{ item.title }}</span>
                                <ChevronRight
                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>

                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem
                                    v-for="subItem in item.items"
                                    :key="subItem.title"
                                >
                                    <SidebarMenuSubButton
                                        as-child
                                        :is-active="isCurrentUrl(subItem.href)"
                                    >
                                        <Link :href="subItem.href">
                                            <component :is="subItem.icon" v-if="subItem.icon" />
                                            <span>{{ subItem.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>

                <!-- CASO 2: Si es un enlace normal simple -->
                <SidebarMenuItem v-else>
                    <SidebarMenuButton
                        as-child
                        :is-active="isCurrentUrl(item.href)"
                        :tooltip="item.title"
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" v-if="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>

            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>