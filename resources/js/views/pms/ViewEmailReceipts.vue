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
              <h5 class="card-title">E-mail Receipts for {{tenant}} <span>| #{{refNo}}</span></h5>
              <p class="card-text">
                <!-- <router-link to="/add-user" custom v-slot="{ href, navigate, isActive }"> -->
                  <a
                    :href="href"
                    :class="{ active: isActive }"
                    class="btn btn-sm btn-success rounded-pill"
                    @click="goBack"
                  >
                    Go Back
                  </a>
                <!-- </router-link> -->
              </p>

              <table id="AllUsersTable" class="table table-borderless">
                <thead>
                  <tr>
                    <!-- <th scope="col">Preview</th> -->
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                    <th scope="col">Sent On</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in emailreceipts" :key="item.id">
                    <td>{{ item.subject }}</td>
                    <td>{{ truncateMessage(item.message, 10) }}</td>
                    <td>{{ format_date(item.created_at) }}</td>
                    <td>
                      <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i> Sent
                      </span>
                    </td>
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
                          <a @click="openModal(item)" class="dropdown-item" href="#">
                            <i class="ri-eye-fill mr-2"></i> View
                          </a>
                          <a @click="deleteReceipt(item.id)" class="dropdown-item" href="#">
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
            <div
                class="modal fade"
                id="viewModal"
                tabindex="-1"
                aria-labelledby="viewModalLabel"
                aria-hidden="true"
              >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">{{ selectedItem?.subject }}</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <p><strong></strong> {{ selectedItem?.message }}</p>
                    <p><strong>Recipient:</strong> {{ tenantMail }}</p>
                    <p><strong>Sent On:</strong> {{ format_time(selectedItem?.created_at) }}</p>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-bs-dismiss="modal"
                    >
                      Close
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
      emailreceipts: [],
      user: [],
      tenant: [],
      refNo: '',
      phoneNumber: '',
      selectedItem: null,
      tenantMail: '',
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
    format_time(value) {
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY h:mm A'); // Add time with AM/PM
      }
    },

    openModal(item) {
      console.log("hyena", item)
      this.selectedItem = item;
      // Launch Bootstrap modal using JavaScript
      const modal = new bootstrap.Modal(document.getElementById('viewModal'));
      modal.show();
    },
    getPhoto() {
      return "users/";
    },
    navigateTo(location) {
      this.$router.push(location)
    },
    truncateMessage(message, length) {
      if (message.length > length) {
        return message.substring(0, length) + '...';
      }
      return message;
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
    getStatement() {
            axios.get('/api/pmsstatement/' + this.$route.params.id).then((response) => {
                this.statement = response.data.pmsstatement[0]
                this.name = this.statement.property.name;
                this.firstName = this.statement.tenant.first_name;
                this.lastName = this.statement.tenant.last_name;
                this.tenant = this.firstName + " " + this.lastName;
                this.tenantMail = this.statement.tenant.email_address;
                this.phoneNumber = this.statement.tenant.phone_number;
                this.unitNumber = this.statement.tenant.pms_unit_id;
                this.tenantId = this.statement.pms_tenant_id;
                this.refNo = this.statement.ref_no;
                this.details = this.statement.details;
                this.date = this.statement.created_at;
                this.status = this.statement.status;
                this.paid = this.statement.paid;
                this.balance = this.statement.balance;
                this.emailCount = this.statement.email_count;
                this.whatsappCount = this.statement.whatsapp_count;
                this.smsCount = this.statement.sms_count;
                this.whatsappReceiptCount = this.statement.whatsapp_receipt_count;
                this.emailReceiptCount = this.statement.email_receipt_count;
                this.total = this.statement.total;
                this.payment = this.statement.payment_method;
                this.statementId = this.statement.id;
                this.waterBill = this.statement.water_bill;
                console.log("statement", this.statement)
            })
        },
    deleteReceipt(id) {
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
          axios.delete('/api/delete-whatsapp-receipt/' + id)
            .then(() => {
              toast.fire(
                'Deleted!',
                'Receipt has been deleted.',
                'success'
              );
              this.getReceipts();
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
    goBack()
    {
      this.$router.go(-1);
    },
    getReceipts() {
      axios.get('/api/emailreceipts/'+ this.$route.params.id)
        .then((response) => {
          this.emailreceipts = response.data.emailreceipts;
          console.log(response);
          setTimeout(() => {
            $("#AllUsersTable").DataTable();
          }, 10);
        })
        .catch((error) => {
          console.error('Error fetching receipts:', error);
        });
    },
    loadLists() {
      axios.get('/api/lists')
        .then((response) => {
          this.allPermissions = response.data.lists.permissions;
          console.log(this.permissions);
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
    this.getReceipts();
    this.getStatement();
    this.user = localStorage.getItem('user');
    this.user = JSON.parse(this.user);
  }
}
</script>
