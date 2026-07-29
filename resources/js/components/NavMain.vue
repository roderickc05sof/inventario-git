<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';

import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
    useSidebar
} from '@/components/ui/sidebar';

import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types/navigation';

interface CustomNavItem extends NavItem {
    items?: CustomNavItem[];
}

defineProps<{
    items: CustomNavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();

const { state, setOpen } = useSidebar();

function expandirSidebar() {
    if (state.value === 'collapsed') {
        setOpen(true);
    }
}
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                
                <Collapsible
                    v-if="item.items && item.items.length > 0"
                    as-child
                    :default-open="item.isActive"
                    class="group/collapsible"
                >
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title" @click="expandirSidebar">
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