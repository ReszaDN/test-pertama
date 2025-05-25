<template>
  <fwb-dropdown close-inside>
    <template #trigger>
      <img
        src="/assets/images/user.png"
        alt="image"
        class="w-10 h-10 object-fit-cover rounded-full"
      />
    </template>
    <fwb-list-group>
      <fwb-list-group-item>
        <div
          class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2"
        >
          <div>
            <h6 class="text-lg text-neutral-900 font-semibold mb-0">
              Shahidul Islam
            </h6>
            <span class="text-neutral-500">Super Admin</span>
          </div>
          <!-- <button type="button" class="hover:text-danger-600">
            <Icon name="radix-icons:cross-1" class="icon text-xl"></Icon>
          </button> -->
        </div>
      </fwb-list-group-item>
      <fwb-list-group-item>
        <a
          class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4"
          href="view-profile.html"
        >
          <Icon name="solar:user-linear" class="icon text-xl"></Icon>
          My Profile</a
        >
      </fwb-list-group-item>
      <fwb-list-group-item>
        <a
          class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4"
          href="company.html"
        >
          <Icon
            name="icon-park-outline:setting-two"
            class="icon text-xl"
          ></Icon>
          Setting</a
        >
      </fwb-list-group-item>
      <fwb-list-group-item>
        <a
          class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4"
          href="javascript:void(0)"
        >
          <Icon name="lucide:power" class="icon text-xl"></Icon>
          Log Out</a
        >
      </fwb-list-group-item>
    </fwb-list-group>
  </fwb-dropdown>
</template>

<script setup>
import { FwbDropdown, FwbListGroup, FwbListGroupItem } from "flowbite-vue";
</script>
