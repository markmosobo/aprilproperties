<template>
    <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <router-link to="/dashboard" custom v-slot="{ href, navigate, isActive }">
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="nav-link"
                    @click="navigate"
                  >
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
        </router-link>
      </li>
      <!-- End Dashboard Nav -->

<!--       <li v-show="user.role_id == 1" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Manage Properties</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/all-properties" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>All Properties</span>
              </a>
            </router-link>
          </li>
          <li>
            <router-link to="/featured-properties" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Featured Properties</span>
              </a>
            </router-link>
          </li>
          <li>
            <router-link to="/all-categories" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >
            <i class="bi bi-circle"></i><span>Categories</span>
            </a>
            </router-link>
          </li>
          <li>
            <router-link to="/all-propertytypes" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >
            <i class="bi bi-circle"></i><span>Types</span>
            </a>
            </router-link>
          </li>
          <li>
            <router-link to="/all-conditions" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >
              <i class="bi bi-circle"></i><span>Conditions</span>
            </a>
            </router-link>
          </li>  
          <li>
            <router-link to="/all-furnishings" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >
              <i class="bi bi-circle"></i><span>Furnishings</span>
            </a>
            </router-link>
          </li>     
          <li>
            <router-link to="/all-locations" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >
              <i class="bi bi-circle"></i><span>Locations</span>
            </a>
            </router-link>
          </li>                       
        </ul>
      </li>

      <li v-show="user.role_id == 1" class="nav-item">
        <router-link to="/all-projects" custom v-slot="{ href, navigate, isActive }">
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="nav-link"
                    @click="navigate"
                  >
          <i class="bi bi-grid"></i>
          <span>Projects</span>
        </a>
        </router-link>
      </li>

      <li v-show="user.role_id == 1" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#blogs-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Manage Blogs</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="blogs-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/all-blogs" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>All Blogs</span>
              </a>
            </router-link>
          </li>
          <li>
            <router-link to="/featured-blogs" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Featured Blogs</span>
              </a>
            </router-link>
          </li>
          <li>
            <router-link to="/all-blogcategories" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >
            <i class="bi bi-circle"></i><span>Categories</span>
            </a>
            </router-link>
          </li>                     
        </ul>
      </li> -->

      <li v-show="user.role_id == 1" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Manage Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/all-users" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>All Users</span>
              </a>
            </router-link>
          </li>  
          <li>
            <router-link to="/roles" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Roles</span>
              </a>
            </router-link>
          </li>
          <li>
            <router-link to="/permissions" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Permissions</span>
              </a>
            </router-link>
          </li>                          
        </ul>
      </li>
      <li v-show="user.role_id == 1" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#sms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Manage About Info</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
 <!--          <li>
            <router-link to="/bulksms" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Send Bulk SMS</span>
              </a>
            </router-link>
          </li> -->  
<!--           <li>
            <router-link to="/sms" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>SMS Tenant</span>
              </a>
            </router-link>
          </li>  -->
          <li>
            <router-link to="/contactus" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Contact Us</span>
              </a>
            </router-link>
            <router-link to="/payments" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Payment Info</span>
              </a>
            </router-link>
          </li>                          
        </ul>
      </li>
      <!-- End Components Nav --> 

<!--       <li v-show="user.role_id == 1" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#configurations-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Configurations</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="configurations-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/all-abouts" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>About Us</span>
              </a>
            </router-link>
            <router-link to="/all-contacts" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-circle"></i><span>Contact Us</span>
              </a>
            </router-link>
          </li>                
        </ul>
      </li> -->

      <!-- agents menu-->
<!--       <li v-show="user.role_id == 2" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#mylisitings-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Manage Listings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="mylisitings-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/my-properties" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
              <i class="bi bi-building"></i><span>My Listings</span>
              </a>
            </router-link>
          </li>                
        </ul>
      </li> -->
      <!-- End Components Nav --> 

      <li class="nav-heading">Property Management</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#land-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Manage Landlords</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="land-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          
          <li>
              <router-link to="/pmslandlords" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
                <i class="bi bi-circle"></i><span>All Landlords</span>
                </a>
              </router-link>
          </li>
        </ul>
      </li>
      <!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-building"></i><span>Manage Properties</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
              <router-link to="/managedproperties" custom v-slot="{ href, navigate, isActive }">
                <a
                  :href="href"
                  :class="{ active: isActive }"
                  class="nav-link"
                  @click="navigate"
                >
                <i class="bi bi-circle"></i><span>All Properties</span>
                </a>
              </router-link>
          </li>
        </ul>
      </li>
      <!-- End Icons Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tenants-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Manage Tenants</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tenants-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/pmstenants" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>All Tenants</span>
            </a>
            </router-link>
          </li>
          <li>
            <router-link to="/pmsrentingtenants" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>Renting Tenants</span>
            </a>
            </router-link>
          </li>
          <li>
            <router-link to="/pmsvacatedtenants" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>Vacated Tenants</span>
            </a>
            </router-link>
          </li>

        </ul>
      </li><!-- End Tenants Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#expenses-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-coin"></i><span>Manage Expenses</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="expenses-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/pmsexpenses" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>All Expenses</span>
            </a>
            </router-link>
          </li>
        </ul>
      </li>
      <!-- End Expenses Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#invoices-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-text"></i><span>Manage Invoices</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="invoices-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/awaitinginvoicing" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>Awaiting Invoicing</span>
            </a>
            </router-link>
          </li>
         <li>
            <router-link to="/invoicestosettle" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>Invoices to Settle</span>
            </a>
            </router-link>
          </li> 
         <li>
            <router-link to="/settledinvoices" custom v-slot="{ href, navigate, isActive }">
              <a
                :href="href"
                :class="{ active: isActive }"
                class="nav-link"
                @click="navigate"
              >          
              <i class="bi bi-circle"></i><span>Settled Invoices</span>
            </a>
            </router-link>
          </li>    
        </ul>
      </li>

<!--       <li class="nav-item">
        <router-link to="/statements" custom v-slot="{ href, navigate, isActive }">
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="nav-link"
                    @click="navigate"
                  >
          <i class="bi bi-file-text"></i>
          <span>All Statements</span>
        </a>
        </router-link>
      </li>

       <li class="nav-item">
        <router-link to="/invoices" custom v-slot="{ href, navigate, isActive }">
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="nav-link"
                    @click="navigate"
                  >
          <i class="bi bi-receipt"></i>
          <span>All Invoices</span>
        </a>
        </router-link>
      </li> -->


    </ul>

  </aside><!-- End Sidebar-->
</template>

<script>
export default {
  name: 'TheSidebar',
  data(){
    return {
      user: []
    }
  },
  mounted(){
    this.user = localStorage.getItem('user');
    this.user = JSON.parse(this.user);
  }
  
}
</script>

<style scoped>

</style>
