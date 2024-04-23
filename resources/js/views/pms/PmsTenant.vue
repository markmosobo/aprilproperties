<template>
    <TheMaster>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <!-- <img :src="getPhoto() + user.image" class="rounded-circle" alt="Profile" /> -->

              <h2>{{user.first_name}} {{user.last_name}}</h2>
              <h3>Tenant</h3>
<!--               <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div> -->
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

<!--                 <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li> -->

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Tenant Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8">{{user.first_name}} {{user.last_name}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone Number</div>
                    <div class="col-lg-9 col-md-8">0{{user.phone_number}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">National ID Number</div>
                    <div class="col-lg-9 col-md-8">{{user.id_number}}</div>
                  </div>

<!--                    <div class="row">
                    <div class="col-lg-3 col-md-4 label">Property</div>
                    <div class="col-lg-9 col-md-8">{{user.property}}</div>
                  </div>

                   <div class="row">
                    <div class="col-lg-3 col-md-4 label">Unit Number</div>
                    <div class="col-lg-9 col-md-8">{{user.unit}}</div>
                  </div> -->

                   <div class="row">
                    <div class="col-lg-3 col-md-4 label">Added On</div>
                    <div class="col-lg-9 col-md-8">{{format_date(user.created_at)}}</div>
                  </div>

                   <div class="row">
                    <div class="col-lg-3 col-md-4 label">Current Status</div>
                    <div v-if="user.status == '1'" class="col-lg-9 col-md-8">Renting</div>
                    <div v-else class="col-lg-9 col-md-8">Vacated</div>
                  </div>

                  <div class="row">
                    <!-- <div class="col-lg-3 col-md-4 label">Role</div> -->
                    <div class="col-lg-9 col-md-8"></div>
                  </div>
<!-- 
                  <h5 class="card-title">Description</h5>
                  <p class="small fst-italic">{{product.description}}</p> -->

                </div>

                <div class="row mb-3">
                  <div class="bg-light clearfix">
                      <button type="button" @click="goToUsers" class="btn btn-sm btn-success float-right rounded-pill">Back</button>
                  </div>  
                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
  </section>
    </TheMaster>
    
 
 
    <!--  actual form -->
 </template>

 <script>
 import TheMaster from "@/components/dashboard/TheMaster.vue";
import axios from 'axios';
import moment from 'moment';

export default {
    data() {
        return {
            user: []
        }
    },
    components: {
        TheMaster

    },
    methods: 
    {
        getUser()
        {
            axios.get('/api/pmstenant/'+this.$route.params.id).then((response) => {
                this.user = response.data.tenant
                console.log("user", this.user)
            })
        },
        format_date(value){
          if(value){
            return moment(String(value)).format('lll')
          }
        },
      goToUsers()
      {
        this.$router.push('/pmstenants')
      },
      getPhoto()
      {
        return "/storage/users/";
      },
    },
    mounted()
    {
        this.getUser();
    }


};

</script>