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
              <h5 class="card-title">System Users <span>| All Users</span></h5>
              <p class="card-text">
                <router-link to="/add-user" custom v-slot="{ href, navigate, isActive }">
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="btn btn-sm btn-success rounded-pill"
                    @click="navigate"
                  >
                    Add User
                  </a>
                </router-link>
              </p>

              <table id="AllUsersTable" class="table table-borderless">
                <thead>
                  <tr>
                    <!-- <th scope="col">Preview</th> -->
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Registered On</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.first_name }} {{ user.last_name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone ?? 'N/A' }}</td>
                    <td>{{ user.role['name'] }}</td>
                    <td>
                      <span v-if="user.status == 0" class="badge bg-warning text-dark">
                        <i class="bi bi-exclamation-triangle me-1"></i> Pending
                      </span>
                      <span v-else-if="user.status == 1" class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i> Active
                      </span>
                      <span v-else class="badge bg-light text-dark">
                        <i class="bi bi-star me-1"></i> Inactive
                      </span>
                    </td>
                    <td>{{ format_date(user.created_at) }}</td>
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
                          <a @click="navigateTo('/viewuser/' + user.id)" class="dropdown-item" href="#">
                            <i class="ri-eye-fill mr-2"></i> View
                          </a>
                          <a @click="resetPassword(user.id)" class="dropdown-item" href="#">
                            <i class="ri-lock-fill mr-2"></i> Reset Password
                          </a>
                          <a @click="generatePermissions(user.id)" class="dropdown-item" href="#">
                            <i class="ri-user-settings-fill mr-2"></i> Generate Permissions
                          </a>
                          <a @click="setPermissions(user)" class="dropdown-item" href="#">
                            <i class="ri-user-settings-fill mr-2"></i> Set Permissions
                          </a>
                          <a v-if="user.status == 2" @click="activateUser(user.id)" class="dropdown-item" href="#">
                            <i class="ri-eye-close-fill mr-2"></i> Activate
                          </a>
                          <a v-if="user.status == 1" @click="deactivateUser(user.id)" class="dropdown-item" href="#">
                            <i class="ri-refresh-fill mr-2"></i> Deactivate
                          </a>
                          <a @click="deleteUser(user.id)" class="dropdown-item" href="#">
                            <i class="ri-delete-bin-line mr-2"></i> Delete
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="invoiceTenantModal" tabindex="-1" aria-labelledby="invoiceTenantModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="invoiceTenantModalLabel">Set Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <p>#{{ permissionUser.first_name }} {{ permissionUser.last_name }}</p>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="assignAllCheck" v-model="assignAllChecked" @change="toggleAllPermissions">
                      <label class="form-check-label" for="assignAllCheck">Assign All Rights & Privileges</label>
                    </div>
                    <p>
                      <strong>Rights & Privileges:</strong>
                      <div class="row">
                        <div v-for="permission in permissions" :key="permission.id" class="col-sm-4">
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" :id="'permission_' + permission.id" v-model="permission.status" :checked="permission.status === 1">
                            <label class="form-check-label" :for="'permission_' + permission.id">{{ permission.permission.name }}</label>
                          </div>
                        </div>
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
      users: [],
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
    getPhoto() {
      return "users/";
    },
    navigateTo(location) {
      this.$router.push(location)
    },
    generatePermissions(id)
    {
      axios.post("api/generate-permissions/"+id)
      .then(function (response) {
         console.log(response);
         // this.step = 1;
         toast.fire(
            'Success!',
            'Permissions generated!',
            'success'
         )
      })
      .catch(function (error) {
         console.log(error);
         Swal.fire(
            'error!',
            response.data.message,
            'error'
         )
      });
    },
    async setPermissions(user) {
      try {
        this.permissionUser = user;

        // Fetch user permissions asynchronously
        await this.getUserPermissions();

        // Show the modal after fetching data
        const modal = new bootstrap.Modal(document.getElementById('invoiceTenantModal'));
        modal.show();
      } catch (error) {
        console.error("Error fetching user permissions:", error);
      }
    },
    async getUserPermissions() {
      try {
        const response = await axios.get('/api/userpermissions/' + this.permissionUser.id);
        this.permissions = response.data.permissions;
        console.log("Permissions", this.permissions);

        if (response.data?.userpermissions?.length > 0) {
          // Handle logic if permissions are found
        } else {
          console.log("No permissions found for the user.");
        }
      } catch (error) {
        console.error("Error fetching user permissions:", error);
        throw error; // Propagate the error upwards
      }
    },
    async confirmSetPermissions() {
      if (this.permissionUser && this.permissionUser.id) {
        try {
          // Set permissions for the user
          await this.settingPermissions();

          // Display success message
          toast.fire(
            'Success!',
            'Permissions saved!',
            'success'
          );

          // Close the modal after saving permissions
          const modal = bootstrap.Modal.getInstance(document.getElementById('invoiceTenantModal'));
          modal.hide();

          // Reload user list or update as needed
          this.loadLists();
        } catch (error) {
          console.error("Error setting permissions:", error);
        }
      }
    },
    settingPermissions() {
      return new Promise((resolve, reject) => {
        this.loading = true;

        // Format permissions for API request
        const formattedPermissions = this.permissions.map(permission => ({
          id: permission.id,
          status: permission.status,
          user_id: this.permissionUser.id,
          permission_id: permission.permission.id
        }));

        // Send API request to update permissions
        axios.post(`api/update-permissions/${this.permissionUser.id}`, {
            permissions: formattedPermissions
          })
          .then(response => {
            this.loading = false;
            resolve(); // Resolve the promise when permissions are updated
          })
          .catch(error => {
            this.loading = false;
            console.error("Error updating permissions:", error);
            reject(error); // Reject the promise if there's an error
          });
      });
    },
    resetPassword(id) {
      axios.put('api/resetpassword/' + id)
        .then(() => {
          toast.fire(
            'Successful',
            'Password has been reset',
            'success'
          );
          this.loadLists();
        })
        .catch(() => {
          console.log('error')
        });
    },
    activateUser(id) {
      axios.put('api/activateuser/' + id)
        .then(() => {
          toast.fire(
            'Successful',
            'User has been activated',
            'success'
          );
          this.loadLists();
        })
        .catch(() => {
          console.log('error')
        });
    },
    deactivateUser(id) {
      axios.put('api/deactivateuser/' + id)
        .then(() => {
          toast.fire(
            'Successful',
            'User has been deactivated',
            'success'
          );
          this.loadLists();
        })
        .catch(() => {
          console.log('error')
        });
    },
    deleteUser(id) {
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
          axios.delete('/api/user/' + id)
            .then(() => {
              toast.fire(
                'Deleted!',
                'User has been deleted.',
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
          this.allPermissions = response.data.lists.permissions;
          console.log(this.permissions);
          setTimeout(() => {
            $("#AllUsersTable").DataTable();
          }, 10);
        })
        .catch((error) => {
          console.error('Error fetching user list:', error);
        });
    },
    toggleAllPermissions() {
      this.permissions.forEach(permission => {
        permission.status = this.assignAllChecked;
      });
    },
  },
  watch: {
    permissions: {
      handler() {
        this.assignAllChecked = this.permissions.every(permission => permission.status);
      },
      deep: true
    }
  },
  mounted() {
    this.loadLists();
    this.user = localStorage.getItem('user');
    this.user = JSON.parse(this.user);
  }
}
</script>
