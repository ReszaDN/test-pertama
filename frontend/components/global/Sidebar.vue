<script lang="ts" setup>
import { Title } from '#build/components';
import { useSidebarStore } from '~/stores/sidebarStore';

const store = useSidebarStore();
const { isSidebarActive } = storeToRefs(store);

// Menus
const menus = ref([
  {
    title: 'Dashboard',
    url: '/dashboard',
    icon: 'solar:home-smile-angle-outline',
    dropdown: false,
  },

])
  
</script>

<template>
  <aside class="sidebar" :class="{ active: isSidebarActive }">
    <button type="button" class="sidebar-close-btn">
      <Icon mode="svg" name="radix-icons:cross-2"></Icon>
    </button>
    <div>
      <a href="index.html" class="sidebar-logo">
        <img src="/assets/images/logo.png" alt="site logo" class="light-logo" />
        <img
          src="/assets/images/logo-light.png"
          alt="site logo"
          class="dark-logo"
        />
        <img
          src="/assets/images/logo-icon.png"
          alt="site logo"
          class="logo-icon"
        />
      </a>
    </div>
    <div class="sidebar-menu-area">
    </div>
  </aside>
</template>
