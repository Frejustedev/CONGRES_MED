<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    LayoutGrid,
    BookOpen,
    FolderGit2,
    Users,
    FileText,
    Calendar,
    Building2,
    Store,
    Mic2,
    DoorOpen,
    Award,
    Sparkles,
    Mail,
    Palette,
    Settings,
    UserPlus,
    Stamp,
    ScanLine,
    Microscope,
    Newspaper,
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const page = usePage();

const perms = computed<string[]>(() => (page.props as any).auth?.permissions ?? []);
const roles = computed<string[]>(() => (page.props as any).auth?.roles ?? []);

const has = (perm: string) => perms.value.includes(perm);
const hasRole = (...names: string[]) => names.some((n) => roles.value.includes(n));
const isAdmin = computed(() => hasRole('super-admin', 'admin-orga', 'admin-scientifique', 'tresorier'));
const isReviewer = computed(() => hasRole('super-admin', 'admin-scientifique', 'reviewer'));
const isStaff = computed(() => hasRole('super-admin', 'admin-orga', 'regisseur'));

const personalNavItems = computed<NavItem[]>(() => [
    { title: 'Tableau de bord', href: dashboard(), icon: LayoutGrid },
]);

const adminNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [];
    if (isAdmin.value) items.push({ title: 'Dashboard admin', href: '/admin', icon: LayoutGrid });
    if (has('registrations.view')) items.push({ title: 'Inscriptions', href: '/admin/registrations', icon: Users });
    if (has('abstracts.view-all')) items.push({ title: 'Résumés', href: '/admin/abstracts', icon: FileText });
    if (has('registrations.invite-groups')) items.push({ title: 'Groupes', href: '/admin/groups', icon: UserPlus });
    if (has('registrations.issue-visa-letter')) items.push({ title: 'Lettres visa', href: '/admin/visa-letters', icon: Stamp });
    if (isAdmin.value) items.push({ title: 'Actualités', href: '/admin/news', icon: Newspaper });
    return items;
});

const contentNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [];
    if (has('event.manage')) items.push({ title: "Événement", href: '/admin/settings/event', icon: Calendar });
    if (has('settings.manage')) items.push({ title: 'Branding', href: '/admin/settings/branding', icon: Palette });
    if (has('settings.manage')) items.push({ title: 'Modules', href: '/admin/settings/modules', icon: Settings });
    if (has('speakers.manage')) items.push({ title: 'Intervenants', href: '/admin/content/speakers', icon: Mic2 });
    if (has('sessions.manage')) items.push({ title: 'Sessions', href: '/admin/content/sessions', icon: Calendar });
    if (has('sessions.manage')) items.push({ title: 'Salles', href: '/admin/content/rooms', icon: DoorOpen });
    if (has('sponsors.manage')) items.push({ title: 'Sponsors', href: '/admin/content/sponsors', icon: Award });
    if (has('exhibitors.manage')) items.push({ title: 'Exposants', href: '/admin/content/exhibitors', icon: Store });
    if (has('symposiums.manage')) items.push({ title: 'Symposiums', href: '/admin/content/symposiums', icon: Sparkles });
    return items;
});

const reviewerNavItems = computed<NavItem[]>(() => {
    if (!isReviewer.value) return [];
    return [{ title: 'Espace évaluateur', href: '/reviewer', icon: Microscope }];
});

const staffNavItems = computed<NavItem[]>(() => {
    if (!isStaff.value) return [];
    return [{ title: 'Scanner Jour J', href: '/staff/scan', icon: ScanLine }];
});

const footerNavItems: NavItem[] = [
    { title: 'Site public', href: '/', icon: BookOpen },
    { title: 'GitHub', href: 'https://github.com/Frejustedev/CONGRES_MED', icon: FolderGit2 },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="personalNavItems" label="Mon espace" />
            <NavMain v-if="adminNavItems.length" :items="adminNavItems" label="Administration" />
            <NavMain v-if="contentNavItems.length" :items="contentNavItems" label="Contenu" />
            <NavMain v-if="reviewerNavItems.length" :items="reviewerNavItems" label="Comité scientifique" />
            <NavMain v-if="staffNavItems.length" :items="staffNavItems" label="Jour J" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
