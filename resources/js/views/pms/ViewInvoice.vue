<template>
  <TheMaster>
    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{ tenant }}</h5>
              <hr class="mb-4">
              <div class="row mb-3">
                <div class="col-lg-12">
                  <div class="d-flex justify-content-between">
                    <div class="label">Bill to Tenant No.</div>
                    <div><strong>{{ tenantId }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-12">
                  <div class="d-flex justify-content-between">
                    <div class="label">Invoice No.</div>
                    <div><strong>{{ refNo }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-12">
                  <div class="d-flex justify-content-between">
                    <div class="label">Date Issued</div>
                    <div><strong>{{ formatDate(date) }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-12">
                  <div class="d-flex justify-content-between">
                    <div class="label">Details</div>
                    <div><strong>{{ details }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-6">
                  <button @click.prevent="viewStatement()" class="btn btn-dark w-100">View Statement</button>
                </div>
                <div class="col-6 text-end">
                  <!-- Optional button can be added here -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card px-2">
            <div class="card-body">
              <h5 class="card-title">Rent - Invoice</h5>
              <hr class="mb-4">
              <form class="row g-3 needs-validation" novalidate method="post" autocomplete="off" @submit.prevent="submit()">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Rent</th>
                      <th scope="col">Security</th>
                      <th scope="col">Garbage</th>
                      <th scope="col">Water</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>{{ formatNumber(rentAmount) }}</td>
                      <td>{{ formatNumber(unitSecurityFee) }}</td>
                      <td>{{ formatNumber(unitGarbageFee) }}</td>
                      <td>{{ formatNumber(waterBillAmount) }}</td>
                      <td v-if="status == 1" scope="row"><span style="color: green;">Settled</span></td>
                      <td v-else scope="row"><span style="color: red;">Unsettled</span></td>
                    </tr>
                    <tr>
                      <th scope="row">Total</th>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><strong>KES. {{ formatNumber(total) }}</strong></td>
                    </tr>
                  </tbody>
                </table>

                <div class="row mt-4">
                  <div class="col-6">
                    <button @click.prevent="cancel()" class="btn btn-dark w-100">Cancel</button>
                  </div>
                  <div class="col-6 text-end">
                    <button @click="printReceipt" class="btn btn-primary w-100" style="background-color: darkgreen; border-color: darkgreen;">Print Invoice</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </TheMaster>
</template>

<script>
import TheMaster from '@/components/dashboard/TheMaster.vue'
import axios from 'axios';
import Swal from 'sweetalert2';
import moment from 'moment';

const toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

export default {
  data() {
    return {
      name: '',
      tenant: '',
      phoneNumber: '',
      unitNumber: '',
      refNo: '',
      details: '',
      date: '',
      status: '',
      paid: '',
      balance: '',
      total: '',
      statementId: '',
      tenantId: '',
      user: [],
      rentAmount: '',
      waterBillAmount: '',
      dateIssued: '',
      unitGarbageFee: '',
      unitSecurityFee: ''
    }
  },
  components: {
    TheMaster,
  },
  methods: {
    getStatement() {
      axios.get('/api/pmsstatement/' + this.$route.params.id).then((response) => {
        this.statement = response.data.pmsstatement[0]
        this.name = this.statement.property.name;
        this.firstName = this.statement.tenant.first_name;
        this.lastName = this.statement.tenant.last_name;
        this.tenant = this.firstName + " " + this.lastName;
        this.phoneNumber = this.statement.tenant.phone_number;
        this.unitNumber = this.statement.tenant.pms_unit_id;
        this.tenantId = this.statement.pms_tenant_id;
        this.getUnit(this.unitNumber);
        this.refNo = this.statement.ref_no;
        this.details = this.statement.details;
        this.date = this.statement.created_at;
        this.status = this.statement.status;
        this.paid = this.statement.paid;
        this.balance = this.statement.balance;
        this.total = this.statement.total;
        this.payment = this.statement.payment_method;
        this.statementId = this.statement.id;
        console.log("statement", this.statement)
      })
    },
    getInvoiceThroStatement() {
      axios.get('/api/pmsinvoicethrostatement/' + this.$route.params.id).then((response) => {
        this.invoice = response.data.invoice;
        this.rentAmount = this.invoice.total;
        this.waterBillAmount = this.invoice.water_bill;
        this.dateIssued = this.invoice.created_at;
        console.log("invoice", this.invoice)
      })
    },
    getUnit(unitNumber) {
      axios.get('/api/pmsunit/' + parseInt(unitNumber))
        .then((response) => {
          this.unit = response.data.unit;
          this.unitName = this.unit.unit_number;
          this.unitRent = this.unit.monthly_rent;
          this.unitSecurityFee = this.unit.security_fee;
          this.unitGarbageFee = this.unit.garbage_fee;
          this.unitType = this.unit.type;
          console.log("unit", this.unit);
        })
        .catch((error) => {
          console.error("Error fetching unit:", error);
        });
    },
    cancel() {
      this.$router.push('/invoices')
    },
    viewStatement() {
      this.$router.push('/viewstatement/' + this.statementId)
    },
    submit() {
      let self = this;
      let payload = {
        paid: this.paid,
        balance: this.balance
      };

      axios.put("/api/pmssettlestatement/" + this.$route.params.id, payload)
        .then(function(response) {
          console.log(response);
          toast.fire('Success!', 'Invoice updated!', 'success');
        })
        .catch(function(error) {
          console.log(error);
        });

      this.$router.push('/invoices');
    },
    printReceipt() {
      this.$router.push('/invoices')

      const printWindow = window.open("", "_blank");
      const receiptContent = this.buildReceiptContent();

      printWindow.document.write(receiptContent);
      printWindow.document.close();
      printWindow.print();
    },
    buildReceiptContent(refNo) {
      const receiptHTML = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Rent Invoice</title>
          <style>
            body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
              background-color: #f5f5f5;
            }
            .receipt {
              max-width: 600px;
              margin: 20px auto;
              padding: 20px;
              background-color: #fff;
              border: 2px solid #ccc;
              border-radius: 10px;
            }
            .receipt-header {
              text-align: center;
              margin-bottom: 20px;
            }
            .receipt-header h1 {
              margin: 10px 0;
              color: #333;
            }
            .receipt-info {
              margin-bottom: 20px;
            }
            .receipt-info p {
              margin: 5px 0;
              color: #555;
            }
            .receipt-table {
              width: 100%;
              border-collapse: collapse;
              margin-bottom: 20px;
            }
            .receipt-table th, .receipt-table td {
              padding: 8px;
              border-bottom: 1px solid #ccc;
            }
            .receipt-table th {
              text-align: left;
              background-color: #f2f2f2;
              color: #333;
            }
            .receipt-table td {
              text-align: left;
              color: #666;
            }
            .receipt-footer {
              text-align: center;
            }
            .receipt-footer p {
              margin: 5px 0;
              color: #777;
            }
          </style>
        </head>
        <body>
          <div class="receipt">
            <img src="@/assets/img/apex-logo.png" alt="">

            <div class="receipt-header">
              <h1>April Properties</h1>
              <p>Kakamega-Webuye Rd, ACK Building</p>
              <p>Phone: (0720) 020-401 | Email: propertapril@gmail.com</p>
            </div>
            <div class="receipt-info">
              <p><strong>Invoice Number:</strong> ${this.refNo}</p>
              <p><strong>Date Issued:</strong> ${this.formatDate(this.dateIssued)}</p>
              <p><strong>Rent Month:</strong> ${this.formatMonth(this.date)}</p>
              <p><strong>Tenant:</strong> ${this.tenant}</p>
              <p><strong>Property:</strong> ${this.name} - ${this.unitName}</p>
            </div>
            <table class="receipt-table">
              <thead>
                <tr>
                  <th>Description</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Rent Payment</td>
                  <td>KES ${this.formatNumber(this.unitRent)}</td>
                </tr>
                <tr>
                  <td>Garbage Collection Fee</td>
                  <td>KES ${this.formatNumber(this.unitGarbageFee)}</td>
                </tr>
                <tr>
                  <td>Security Fee</td>
                  <td>KES ${this.formatNumber(this.unitSecurityFee)}</td>
                </tr>
                <tr>
                  <td>Water Bill</td>
                  <td>KES ${this.formatNumber(this.waterBillAmount)}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>Total KES. Incl. Water Bill:</th>
                  <td>KES ${this.formatNumber(this.total)}</td>
                </tr>
              </tfoot>
            </table>
            <div class="receipt-footer">
              <p>You were invoiced by ${this.user.first_name} ${this.user.last_name}. For MPESA payment:</p>
              <p>MPESA Paybill</p>
              <p>Enter Business Number:86767</p>
              <p>Account No. 7576565</p>
            </div>
          </div>
        </body>
        </html>
      `;

      return receiptHTML;
    },
    formatMonth(value) {
      if (value) {
        return moment(String(value)).format('MMM YYYY');
      }
    },
    formatDate(value) {
      if (value) {
        return moment(String(value)).format('MM/DD/YYYY');
      }
    },
    formatNumber(value) {
      return value.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    },
  },
  mounted() {
    this.getInvoiceThroStatement();
    this.getStatement();
    this.user = JSON.parse(localStorage.getItem('user'));
  }
}
</script>
