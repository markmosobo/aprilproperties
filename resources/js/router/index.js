import {  createRouter, createWebHistory  } from 'vue-router';
// import Index from '../views/Index.vue'
// import About from '../views/About.vue'
// import Contact from '../views/Contact.vue'
// import Properties from '../views/Properties.vue'
// import Property from '../views/Property.vue'
// import Blogs from '../views/Blogs.vue'
// import Blog from '../views/Blog.vue'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import AllProjects from '../views/projects/AllProjects.vue'
import AddProject from '../views/projects/AddProject.vue'
import ViewProject from '../views/projects/ViewProject.vue'
import EditProject from '../views/projects/EditProject.vue'
import AllProperties from '../views/properties/AllProperties.vue'
import FeaturedProperties from '../views/properties/FeaturedProperties.vue'
import MyProperties from '../views/properties/MyProperties.vue'
import AddProperty from '../views/properties/AddProperty.vue'
import ManagedProperties from '../views/pms/ManagedProperties.vue'
import AddPmsProperty from '../views/pms/AddPmsProperty.vue'
import ViewPmsProperty from '../views/pms/ViewPmsProperty.vue'
import EditPmsProperty from '../views/pms/EditPmsProperty.vue'
import AddPmsLandlord from '../views/pms/AddPmsLandlord.vue'
import EditPmsLandlord from '../views/pms/EditPmsLandlord.vue'
import AddPmsTenant from '../views/pms/AddPmsTenant.vue'
import AddPmsCurrentTenant from '../views/pms/AddPmsCurrentTenant.vue'
import ViewProperty from '../views/properties/ViewProperty.vue'
import EditProperty from '../views/properties/EditProperty.vue'
import AllCategories from '../views/categories/AllCategories.vue'
import AddCategory from '../views/categories/AddCategory.vue'
import ViewCategory from '../views/categories/ViewCategory.vue'
import EditCategory from '../views/categories/EditCategory.vue'
import AllPropertyTypes from '../views/propertytypes/AllPropertyTypes.vue'
import AddPropertyType from '../views/propertytypes/AddPropertyType.vue'
import ViewPropertyType from '../views/propertytypes/ViewPropertyType.vue'
import EditPropertyType from '../views/propertytypes/EditPropertyType.vue'
import AllConditions from '../views/conditions/AllConditions.vue'
import AddCondition from '../views/conditions/AddCondition.vue'
import ViewCondition from '../views/conditions/ViewCondition.vue'
import EditCondition from '../views/conditions/EditCondition.vue'
import AllFurnishings from '../views/furnishings/AllFurnishings.vue'
import AddFurnishing from '../views/furnishings/AddFurnishing.vue'
import ViewFurnishing from '../views/furnishings/ViewFurnishing.vue'
import EditFurnishing from '../views/furnishings/EditFurnishing.vue'
import AllLocations from '../views/locations/AllLocations.vue'
import AddLocation from '../views/locations/AddLocation.vue'
import ViewLocation from '../views/locations/ViewLocation.vue'
import EditLocation from '../views/locations/EditLocation.vue'
import AllBlogCategories from '../views/blogcategories/AllBlogCategories.vue'
import AddBlogCategory from '../views/blogcategories/AddBlogCategory.vue'
import AllBlogs from '../views/blogs/AllBlogs.vue'
import FeaturedBlogs from '../views/blogs/FeaturedBlogs.vue'
import AddBlog from '../views/blogs/AddBlog.vue'
import EditBlog from '../views/blogs/EditBlog.vue'
import ViewBlog from '../views/blogs/ViewBlog.vue'
import AllAbouts from '../views/about/AllAbouts.vue'
import AddAbout from '../views/about/AddAbout.vue'
import EditAbout from '../views/about/EditAbout.vue'
import EditService from '../views/services/EditService.vue'
import AllContacts from '../views/contacts/AllContacts.vue'
import EditContact from '../views/contacts/EditContact.vue'
import AddSocialLink from '../views/sociallinks/AddSocialLink.vue'
import EditSocialLink from '../views/sociallinks/EditSocialLink.vue'
import Profile from '../views/Profile.vue'
import AllUsers from '../views/users/AllUsers.vue'
import AddUser from '../views/users/AddUser.vue'
import ViewUser from '../views/users/ViewUser.vue'
// import OurServices from '../views/OurServices.vue'
// import Service from '../views/Service.vue'
// import SearchResultPage from '../views/SearchResultPage.vue'
// import Projects from '../views/Projects.vue'
import Roles from '../views/roles/Roles.vue'
import AddRole from '../views/roles/AddRole.vue'
// import Project from '../views/Project.vue'
import PmsLandlords from '../views/pms/PmsLandlords.vue'
import PmsTenants from '../views/pms/PmsTenants.vue'
import PmsExpenses from '../views/pms/PmsExpenses.vue'
import PmsUnits from '../views/pms/PmsUnits.vue'
import AddPmsUnit from '../views/pms/AddPmsUnit.vue'
import EditPmsUnit from '../views/pms/EditPmsUnit.vue'
import ViewPmsUnit from '../views/pms/ViewPmsUnit.vue'
import PmsTenant from '../views/pms/PmsTenant.vue'
import EditPmsTenant from '../views/pms/EditPmsTenant.vue'
import AddPmsExpense from '../views/pms/AddPmsExpense.vue'
import EditPmsExpense from '../views/pms/EditPmsExpense.vue'
import PmsPropertyStatements from '../views/pms/PmsPropertyStatements.vue'
import PmsMonthPropertyStatements from '../views/pms/PmsMonthPropertyStatements.vue'
import PmsLastMonthPropertyStatements from '../views/pms/PmsLastMonthPropertyStatements.vue'
import PmsLastNinetyPropertyStatements from '../views/pms/PmsLastNinetyPropertyStatements.vue'
import PmsYearPropertyStatements from '../views/pms/PmsYearPropertyStatements.vue'
import PmsQuarterPropertyStatements from '../views/pms/PmsQuarterPropertyStatements.vue'
import PmsLastYearPropertyStatements from '../views/pms/PmsLastYearPropertyStatements.vue'
import PmsAllPropertyStatements from '../views/pms/PmsAllPropertyStatements.vue'
import PmsStatements from '../views/pms/PmsStatements.vue'
import PmsTenantStatements from '../views/pms/PmsTenantStatements.vue'
import PmsMonthTenantStatements from '../views/pms/PmsMonthTenantStatements.vue'
import PmsLastMonthTenantStatements from '../views/pms/PmsLastMonthTenantStatements.vue'
import PmsLastNinetyTenantStatements from '../views/pms/PmsLastNinetyTenantStatements.vue'
import PmsYearTenantStatements from '../views/pms/PmsYearTenantStatements.vue'
import PmsQuarterTenantStatements from '../views/pms/PmsQuarterTenantStatements.vue'
import PmsLastYearTenantStatements from '../views/pms/PmsLastYearTenantStatements.vue'
import PmsAllTenantStatements from '../views/pms/PmsAllTenantStatements.vue'
import PmsLandlordStatements from '../views/pms/PmsLandlordStatements.vue'
import PmsLandlordProperties from '../views/pms/PmsLandlordProperties.vue'
import ViewStatement from '../views/pms/ViewStatement.vue'
import EditStatement from '../views/pms/EditStatement.vue'
import SettleStatement from '../views/pms/SettleStatement.vue'
import InvoiceStatement from '../views/pms/InvoiceStatement.vue'

import AwaitingInvoicing from '../views/pms/AwaitingInvoicing.vue'
import InvoicestoSettle from '../views/pms/InvoicestoSettle.vue'
import SettledInvoices from '../views/pms/SettledInvoices.vue'
import PmsInvoices from '../views/pms/PmsInvoices.vue'
import ViewInvoice from '../views/pms/ViewInvoice.vue'
import PmsTenantInvoices from '../views/pms/PmsTenantInvoices.vue'

import BulkSms from '../views/sms/BulkSms.vue'
import Sms from '../views/sms/Sms.vue'

function guardMyroute(to, from, next)
{
 var isAuthenticated= false;
//this is just an example. You will have to find a better or 
// centralised way to handle you localstorage data handling 
if(localStorage.getItem('user'))
  isAuthenticated = true;
 else
  isAuthenticated= false;
 if(isAuthenticated) 
 {
  next(); // allow to enter route
 } 
 else
 {
  next('/login'); // go to '/login';
 }
}

const routes = [
    {
        path:'/',
        name: 'index',
        component: Login
    },

    {
        path:'/login',
        name: 'login',
        component: Login
    },
    {
        path:'/register',
        name: 'register',
        component: Register
    },
    //auth routes
    {
        path:'/dashboard',
        name: 'dashboard',
        component: Home,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-projects',
        name: 'all-projects',
        component: AllProjects,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-properties',
        name: 'all-properties',
        component: AllProperties,
        beforeEnter : guardMyroute,
    },
    {
        path:'/featured-properties',
        name: 'featured-properties',
        component: FeaturedProperties,
        beforeEnter : guardMyroute,
    },
    {
        path:'/my-properties',
        name: 'my-properties',
        component: MyProperties,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-categories',
        name: 'all-categories',
        component: AllCategories,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-propertytypes',
        name: 'all-propertytypes',
        component: AllPropertyTypes,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-conditions',
        name: 'all-conditions',
        component: AllConditions,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-furnishings',
        name: 'all-furnishings',
        component: AllFurnishings,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-locations',
        name: 'all-locations',
        component: AllLocations,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-blogcategories',
        name: 'all-blogcategories',
        component: AllBlogCategories,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-blogs',
        name: 'all-blogs',
        component: AllBlogs,
        beforeEnter : guardMyroute,
    },
    {
        path:'/featured-blogs',
        name: 'featured-blogs',
        component: FeaturedBlogs,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-abouts',
        name: 'all-abouts',
        component: AllAbouts,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-contacts',
        name: 'all-contacts',
        component: AllContacts,
        beforeEnter : guardMyroute,
    },
    {
        path:'/all-users',
        name: 'all-users',
        component: AllUsers,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-user',
        name: 'add-user',
        component: AddUser,
        beforeEnter : guardMyroute,
    },    
    //forms
    {
        path:'/add-category',
        name: 'add-category',
        component: AddCategory,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-project',
        name: 'add-project',
        component: AddProject,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-property',
        name: 'add-property',
        component: AddProperty,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-propertytype',
        name: 'add-propertytype',
        component: AddPropertyType,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-condition',
        name: 'add-condition',
        component: AddCondition,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-furnishing',
        name: 'add-furnishing',
        component: AddFurnishing,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-location',
        name: 'add-location',
        component: AddLocation,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-sociallink',
        name: 'add-sociallink',
        component: AddSocialLink,
        beforeEnter : guardMyroute,
    },
    {
        path:'/editproject/:id',
        name: 'editproject',
        component: EditProject,
        beforeEnter : guardMyroute,
    },
    {
        path:'/editproperty/:id',
        name: 'editproperty',
        component: EditProperty,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-category/:id',
        name: 'edit-category',
        component: EditCategory,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-propertytype/:id',
        name: 'edit-propertytype',
        component: EditPropertyType,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-condition/:id',
        name: 'edit-condition',
        component: EditCondition,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-furnishing/:id',
        name: 'edit-furnishing',
        component: EditFurnishing,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-location/:id',
        name: 'edit-location',
        component: EditLocation,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-about/:id',
        name: 'edit-about',
        component: EditAbout,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-contact/:id',
        name: 'edit-contact',
        component: EditContact,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-service/:id',
        name: 'edit-service',
        component: EditService,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-blog/:id',
        name: 'edit-blog',
        component: EditBlog,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-sociallink/:id',
        name: 'edit-sociallink',
        component: EditSocialLink,
        beforeEnter : guardMyroute,
    },
    {
        path: '/viewproject/:id',
        name: 'viewproject',
        component: ViewProject,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewproperty/:id',
        name: 'viewproperty',
        component: ViewProperty,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewcategory/:id',
        name: 'viewcategory',
        component: ViewCategory,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewpropertytype/:id',
        name: 'viewpropertytype',
        component: ViewPropertyType,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewcondition/:id',
        name: 'viewcondition',
        component: ViewCondition,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewfurnishing/:id',
        name: 'viewfurnishing',
        component: ViewFurnishing,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewlocation/:id',
        name: 'viewlocation',
        component: ViewLocation,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewblog/:id',
        name: 'viewblog',
        component: ViewBlog,
        beforeEnter : guardMyroute,

    },
    {
        path: '/viewuser/:id',
        name: 'viewuser',
        component: ViewUser,
        beforeEnter : guardMyroute,

    },
    {
        path:'/add-blogcategory',
        name: 'add-blogcategory',
        component: AddBlogCategory,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-blog',
        name: 'add-blog',
        component: AddBlog,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-about',
        name: 'add-about',
        component: AddAbout,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-sociallink',
        name: 'add-sociallink',
        component: AddSocialLink,
        beforeEnter : guardMyroute,
    },
    {
        path:'/roles',
        name: 'roles',
        component: Roles,
        beforeEnter : guardMyroute,
    },    
    {
        path:'/add-role',
        name: 'add-role',
        component: AddRole,
        beforeEnter : guardMyroute,
    },    
    {
        path:'/profile',
        name: 'profile',
        component: Profile,
        beforeEnter : guardMyroute,
        // meta: { requiresAuth: true }
         // Add this meta field to indicate that authentication is required

    },

    //pms routes
    {
        path:'/managedproperties',
        name: 'managedproperties',
        component: ManagedProperties,
        // component : () => import("../views/pms/PmsProperties.vue"),
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslandlordproperties/:id',
        name: 'pmslandlordproperties',
        component: PmsLandlordProperties,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsproperties/:id',
        name: 'pmsproperties',
        component: ViewPmsProperty,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/pmsunits/:id',
        name: 'pmsunits',
        component: PmsUnits,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/add-pmsunit/:id',
        name: 'add-pmsunit',
        component: AddPmsUnit,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-pmsunit/:id',
        name: 'edit-pmsunit',
        component: EditPmsUnit,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/view-pmsunit/:id',
        name: 'view-pmsunit',
        component: ViewPmsUnit,
        beforeEnter : guardMyroute,
    },               
    {
        path:'/add-pmsproperty',
        name: 'add-pmsproperty',
        component: AddPmsProperty,
        beforeEnter : guardMyroute,
    },
    {
        path:'/edit-pmsproperty/:id',
        name: 'edit-pmsproperty',
        component: EditPmsProperty,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslandlords',
        name: 'pmslandlords',
        component: PmsLandlords,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-pmslandlord',
        name: 'add-pmslandlord',
        component: AddPmsLandlord,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/edit-pmslandlord/:id',
        name: 'edit-pmslandlord',
        component: EditPmsLandlord,
        beforeEnter : guardMyroute,
    },    
    {
        path:'/pmstenants',
        name: 'pmstenants',
        component: PmsTenants,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmstenant/:id',
        name: 'pmstenant',
        component: PmsTenant,
        beforeEnter : guardMyroute,
    },        
    {
        path:'/add-pmstenant',
        name: 'add-pmstenant',
        component: AddPmsTenant,
        beforeEnter : guardMyroute,
    },
    {
        path:'/add-pmscurrenttenant',
        name: 'add-pmscurrenttenant',
        component: AddPmsCurrentTenant,
        beforeEnter : guardMyroute,
    },     
    {
        path:'/edit-pmstenant/:id',
        name: 'edit-pmstenant',
        component: EditPmsTenant,
        beforeEnter : guardMyroute,
    },    
    {
        path:'/pmsexpenses',
        name: 'pmsexpenses',
        component: PmsExpenses,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/add-pmsexpense',
        name: 'add-pmsexpense',
        component: AddPmsExpense,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/edit-pmsexpense/:id',
        name: 'edit-pmsexpense',
        component: EditPmsExpense,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/pmspropertystatements/:id',
        name: 'pmspropertystatements',
        component: PmsPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsmonthpropertystatements/:id',
        name: 'pmsmonthpropertystatements',
        component: PmsMonthPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslastmonthpropertystatements/:id',
        name: 'pmslastmonthpropertystatements',
        component: PmsLastMonthPropertyStatements,
        beforeEnter : guardMyroute,
    },
      {
        path:'/pmslastninetypropertystatements/:id',
        name: 'pmslastninetypropertystatements',
        component: PmsLastNinetyPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsyearpropertystatements/:id',
        name: 'pmsyearpropertystatements',
        component: PmsYearPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsquarterpropertystatements/:id',
        name: 'pmsquarterpropertystatements',
        component: PmsQuarterPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslastyearpropertystatements/:id',
        name: 'pmslastyearpropertystatements',
        component: PmsLastYearPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsallpropertystatements/:id',
        name: 'pmsallpropertystatements',
        component: PmsAllPropertyStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmstenantstatements/:id',
        name: 'pmstenantstatements',
        component: PmsTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsmonthtenantstatements/:id',
        name: 'pmsmonthtenantstatements',
        component: PmsMonthTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslastmonthtenantstatements/:id',
        name: 'pmslastmonthtenantstatements',
        component: PmsLastMonthTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslastninetytenantstatements/:id',
        name: 'pmslastninetytenantstatements',
        component: PmsLastNinetyTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsyeartenantstatements/:id',
        name: 'pmsyeartenantstatements',
        component: PmsYearTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsquartertenantstatements/:id',
        name: 'pmsquartertenantstatements',
        component: PmsQuarterTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslastyeartenantstatements/:id',
        name: 'pmslastyeartenantstatements',
        component: PmsLastYearTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmsalltenantstatements/:id',
        name: 'pmsalltenantstatements',
        component: PmsAllTenantStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslandlordstatements/:id',
        name: 'pmslandlordstatements',
        component: PmsLandlordStatements,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmslandlordproperties/:id',
        name: 'pmslandlordproperties',
        component: PmsLandlordProperties,
        beforeEnter : guardMyroute,
    },
    {
        path:'/awaitinginvoicing',
        name: 'awaitinginvoicing',
        component: AwaitingInvoicing,
        beforeEnter : guardMyroute,
    },
    {
        path:'/invoicestosettle',
        name: 'invoicestosettle',
        component: InvoicestoSettle,
        beforeEnter : guardMyroute,
    },
    {
        path:'/settledinvoices',
        name: 'settledinvoices',
        component: SettledInvoices,
        beforeEnter : guardMyroute,
    },
    {
        path:'/invoices',
        name: 'invoices',
        component: PmsInvoices,
        beforeEnter : guardMyroute,
    },
    {
        path:'/viewinvoice/:id',
        name: 'viewinvoice',
        component: ViewInvoice,
        beforeEnter : guardMyroute,
    },
    {
        path:'/pmstenantinvoices/:id',
        name: 'pmstenantinvoices',
        component: PmsTenantInvoices,
        beforeEnter : guardMyroute,
    },
    {
        path:'/statements',
        name: 'statements',
        component: PmsStatements,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/viewstatement/:id',
        name: 'viewstatement',
        component: ViewStatement,
        beforeEnter : guardMyroute,
    },
    {
        path:'/editstatement/:id',
        name: 'editstatement',
        component: EditStatement,
        beforeEnter : guardMyroute,
    },
    {
        path:'/invoicestatement/:id',
        name: 'invoicestatement',
        component: InvoiceStatement,
        beforeEnter : guardMyroute,
    }, 
    {
        path:'/settlestatement/:id/:tenantId',
        name: 'settlestatement',
        component: SettleStatement,
        beforeEnter : guardMyroute,
    },
    {
        path:'/bulksms',
        name: 'bulksms',
        component: BulkSms,
        beforeEnter : guardMyroute,
    
    },
    {
        path:'/sms',
        name: 'sms',
        component: Sms,
        beforeEnter : guardMyroute,
    }                              
];

const router = createRouter({
    history: createWebHistory('/'),
    routes
});



export default router;