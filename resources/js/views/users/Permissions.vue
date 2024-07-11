<template>
  <TheMaster>
    <section class="section dashboard">
      <div class="row">
        <!-- Top Selling -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">
            <div class="filter">
              <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul> -->
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">All Permissions <span>| User rights and privileges</span></h5>
              <p class="card-text">
                <router-link to="/add-permission" custom v-slot="{ href, navigate, isActive }">
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="btn btn-sm btn-success rounded-pill"
                    @click="navigate"
                  >
                    Add Permission
                  </a>
                </router-link>
              </p>

              <table id="AllPermissionsTable" class="table table-borderless">
                <thead>
                  <tr>
                    <!-- <th scope="col">Preview</th> -->
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="permission in permissions" :key="permission.id">
                    <td>{{ permission.code }}</td>
                    <td>{{ permission.name ?? 'N/A' }}</td>
                    <td>
                      <div class="btn-group" role="group">
                        <button
                          id="btnGroupDrop1"
                          type="button"
                          class="btn btn-sm btn-success rounded-pill dropdown-toggle"
                          data-toggle="dropdown"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                   <!--        <a @click="navigateTo('/viewuser/' + user.id)" class="dropdown-item" href="#">
                            <i class="ri-eye-fill mr-2"></i> View
                          </a> -->
                          <a @click="editPermission(permission)" class="dropdown-item" href="#">
                            <i class="ri-pencil-fill mr-2"></i> Edit
                          </a>
                          <a @click="deletePermission(permission.id)" class="dropdown-item" href="#">
                            <i class="ri-delete-bin-line mr-2"></i> Delete
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>

            <!--Edit Permission Modal -->
            <div class="modal fade" id="invoiceTenantModal" tabindex="-1" aria-labelledby="invoiceTenantModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="invoiceTenantModalLabel">Set Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>
                      <strong>Rights & Privileges:</strong>
                      <div class="row">
        
                      </div>
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" style="background-color: darkgreen; border-color: darkgreen;" class="btn btn-primary" @click="confirmSetPermissions">
                      <span v-if="loading">
                        <i class="fa fa-spinner fa-spin"></i> Saving...
                      </span>
                      <span v-else>
                        Save changes
                      </span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Top Selling -->

      </div>
    </section>
  </TheMaster>
</template>

<script>
import TheMaster from "@/components/dashboard/TheMaster.vue";
import axios from "axios";
import Swal from 'sweetalert2';
import "jquery/dist/jquery.min.js";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import moment from 'moment';

const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

export default {
  components: {
    TheMaster,
  },
  data() {
    return {
      permissions: [],
      user: [],
      permissionUser: '',
      permissions: [],
      assignAllChecked: false,
      loading: false
    }
  },
  methods: {
    format_date(value) {
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
        
      }
    },
    navigateTo(location) {
      this.$router.push(location)
    },
    editPermission(permission)
    {

    },
    deletePermission(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Send request to delete user
          axios.delete('/api/permission/' + id)
            .then(() => {
              toast.fire(
                'Deleted!',
                'Permission has been deleted.',
                'success'
              );
              this.loadLists();
            })
            .catch(() => {
              Swal.fire(
                'Failed!',
                'There was something wrong.',
                'warning'
              );
            });
        } else if (result.isDenied) {
          console.log('Cancelled')
        }
      });
    },
    loadLists() {
      axios.get('api/lists')
        .then((response) => {
          this.users = response.data.lists.users;
          this.permissions = response.data.lists.permissions;
          console.log(this.permissions);
          setTimeout(() => {
            $("#AllPermissionsTable").DataTable();
          }, 10);
        })
        .catch((error) => {
          console.error('Error fetching user list:', error);
        });
    },
  },
  mounted() {
    this.loadLists();
    this.user = localStorage.getItem('user');
    this.user = JSON.parse(this.user);
  }
}
</script>
