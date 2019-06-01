<template>
  <div>
    <app-users-administration></app-users-administration>
  </div>
</template>

<script>
import AppSidebar from "./Sidebar";
import AppUsersAdministration from "./UsersAdministration";

export default {
  components: {
    AppUsersAdministration,
    AppSidebar
  }
};
</script>

<style lang="scss">
.page {
  position: relative;
  top: 0;
  left: 0;
  right: 0;
  bottom: 100px;
}
</style>
