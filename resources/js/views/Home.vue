<template>
  <TheMaster>
    <section v-if="user.role_id == 1" class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">

            <!-- Properties Card -->
            <div @click="goProperties" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-success">All Properties <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <span style="color: darkgreen;"><i class="bi bi-building"></i></span>
                    </div>
                    <div class="ps-3">
                      <h6>{{ pmsPropertyCount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Properties Card -->

            <!-- Rented Units Card -->
            <div @click="goRentedUnits" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-warning">Rented Units <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-house-door" style="color: orange;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ pmsrentedpropertycount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Rented Units Card -->

            <!-- Vacant Units Card -->
            <div @click="goVacantUnits" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-danger">Vacant Units <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-house" style="color: red;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ pmsvacantpropertycount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Vacant Units Card -->

            <!-- Users Card -->
            <div @click="goUsers" class="col-xxl-3 col-xl-4 mb-4">
              <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-primary">Users <span>| All System Users</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-people" style="color: blue;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ userscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Users Card -->

            <!-- Landlords Card -->
            <div @click="goLandlords" class="col-xxl-3 col-xl-4 mb-4">
              <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-info">Landlords <span>| All Landlords</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-person-lines-fill" style="color: teal;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ landlordscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Landlords Card -->

            <!-- Tenants Card -->
            <div @click="goTenants" class="col-xxl-3 col-xl-4 mb-4">
              <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-secondary">Tenants <span>| All Tenants</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-person-badge" style="color: darkslategray;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ tenantscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Tenants Card -->

            <!-- Renting Tenants Card -->
            <div @click="goRentingTenants" class="col-xxl-3 col-xl-4 mb-4">
              <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-secondary">Renting Tenants <span>| Renting Tenants</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-person-badge" style="color: darkslategray;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ rentingTenantscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Tenants Card -->

            <!-- Vacated Tenants Card -->
            <div @click="goVacatedTenants" class="col-xxl-3 col-xl-4 mb-4">
              <div class="card info-card customers-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-secondary">Vacated Tenants <span>| Vacated Tenants</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-person-badge" style="color: darkslategray;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ vacatedTenantscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Tenants Card -->

          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>

    <section v-if="user.role_id == 2" class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">

            <!-- Awaiting Invoicing Card -->
            <div @click="goAwaitingInvoicing" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-success">Awaiting Invoicing <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <span style="color: darkgreen;"><i class="bi bi-file-earmark-text" style="color: darkgreen;"></i></span>
                    </div>
                    <div class="ps-3">
                      <h6>{{ awaitingInvoicingCount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Awaiting Invoicing Card -->

            <!-- Awaiting Settling Card -->
            <div @click="goAwaitingSettling" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-warning" style="color: darkorange;">Awaiting Settling <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-clipboard" style="color: darkorange;"></i>

                    </div>
                    <div class="ps-3">
                      <h6>{{ awaitingSettlingCount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Awaiting Settling Card -->

            <!-- Settled Invoices Card -->
            <div @click="goSettledInvoices" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-danger">Settled Invoices <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-file-earmark-check" style="color: red;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ settledInvoicesCount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Settled Invoices Card -->

            <!-- All Properties Card -->
            <div @click="goProperties" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card sales-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-success">All Properties <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <span style="color: darkgreen;"><i class="bi bi-building"></i></span>
                    </div>
                    <div class="ps-3">
                      <h6>{{ pmsPropertyCount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End All Properties Card -->

            <!-- Rented Units Card -->
            <div @click="goRentedUnits" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-warning">Rented Units <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-house-door" style="color: orange;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ pmsrentedpropertycount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Rented Units Card -->

            <!-- Vacant Units Card -->
            <div @click="goVacantUnits" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-danger">Vacant Units <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-house" style="color: red;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ pmsvacantpropertycount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Vacant Units Card -->

            <!-- Landlords Card -->
            <div @click="goLandlords" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-danger">All Landlords <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-house" style="color: red;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ landlordscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Landlords Card -->

            <!-- Tenants Card -->
            <div @click="goTenants" class="col-xxl-3 col-md-4 mb-4">
              <div class="card info-card revenue-card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-danger">All Tenants <span>| All Time</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-light">
                      <i class="bi bi-house" style="color: red;"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ tenantscount }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Tenants Card -->

          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>
  </TheMaster>
</template>

<script>
import TheMaster from '@/components/dashboard/TheMaster.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

export default {
  name: 'Home',
  components: {
    TheMaster,
  },
  data() {
    return {
      user: {},
      properties: [],
      openproperties: [],
      closedproperties: [],
      users: [],
      pmsPropertyCount: 0,
      pmsvacantpropertycount: 0,
      pmsrentedpropertycount: 0,
      userscount: 0,
      landlordscount: 0,
      tenantscount: 0,
      rentingTenantscount: 0,
      vacatedTenantscount: 0,
      awaitingInvoicingCount: 0, // New data property for awaiting invoicing
      awaitingSettlingCount: 0, // New data property for awaiting settling
      settledInvoicesCount: 0, // New data property for settled invoices
    };
  },
  methods: {
    navigateTo(location) {
      this.$router.push(location);
    },
    goAwaitingInvoicing()
    {
      this.$router.push('/awaitinginvoicing')
    },
    goAwaitingSettling()
    {
      this.$router.push('/invoicestosettle')
    },
    goSettledInvoices()
    {
      this.$router.push('/settledinvoices')
    },
    goProperties()
    {
      this.$router.push('/managedproperties')
    },
    goUsers()
    {
      this.$router.push('/all-users')
    },
    goLandlords()
    {
      this.$router.push('/pmslandlords')
    },
    goTenants()
    {
      this.$router.push('/pmstenants')
    },
    goRentingTenants()
    {
      this.$router.push('/pmsrentingtenants')
    },
    goVacatedTenants()
    {
      this.$router.push('/pmsvacatedtenants')
    },
    goRentedUnits()
    {
      this.$router.push('/rentedunits')
    },
    goVacantUnits()
    {
      this.$router.push('/vacantunits')
    },
    loadLists() {
      axios.get('api/lists').then(response => {
        const data = response.data.lists;
        this.properties = data.properties;
        this.openproperties = data.openproperties;
        this.closedproperties = data.closedproperties;
        this.users = data.users;
        this.pmsPropertyCount = data.pmspropertycount;
        this.pmsvacantpropertycount = data.pmsvacantpropertycount;
        this.pmsrentedpropertycount = data.pmsrentedpropertycount;
        this.userscount = data.userscount;
        this.landlordscount = data.landlordscount;
        this.tenantscount = data.tenantscount;
        this.vacatedTenantscount = data.vacatedtenantscount;
        this.rentingTenantscount = data.rentingtenantscount;
        this.awaitingInvoicingCount = data.allawaitinginvoicing.length; // Fetch new data
        this.awaitingSettlingCount = data.invoicestosettle.length; // Fetch new data
        this.settledInvoicesCount = data.settledinvoices.length; // Fetch new data
      });
    }
  },
  mounted() {
    this.user = JSON.parse(localStorage.getItem('user')) || {};
    this.loadLists();
  }
};
</script>

<style scoped>
.card {
  transition: transform 0.2s;
}

.card:hover {
  transform: scale(1.02);
}

.bg-light {
  background-color: rgba(255, 255, 255, 0.8);
}
</style>
