<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Role;
use App\Models\Category;
use App\Models\PropertyType;
use App\Models\Condition;
use App\Models\Furnishing;
use App\Models\Location;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\About;
use App\Models\Service;
use App\Models\Contact;
use App\Models\SocialLink;
use App\Models\Message;
use App\Models\Project;
use App\Models\Landlord;
use App\Models\PmsProperty;
use App\Models\PmsUnit;
use App\Models\PmsTenant;
use App\Models\PmsExpense;
use App\Models\PmsStatement;

class ListController extends Controller
{
    public function index()
    {
        $users = User::latest()->with('role')->get();
        $properties = Property::latest()->with('type','images')->get();
        $pmsproperties = PmsProperty::latest()->with('landlord','images','units')->get();
        $saleproperties = Property::latest()->with('type','images')->where('property_status','sale')->where('status',1)->get();
        $rentproperties = Property::latest()->with('type','images')->where('property_status','rent')->where('status',1)->get();
        $featuredproperties = Property::latest()->where('featured',1)->with('type','images')->where('status','=',1)->orWhere('status','=',2)->get();
        $roles = Role::all();
        $categories = Category::all();
        $propertytypes = PropertyType::all();
        $conditions = Condition::all();
        $furnishings = Furnishing::all();
        $locations = Location::all();
        $blogs = Blog::with('category')->get();
        $featuredblogs = Blog::latest()->where('featured',1)->where('status',1)->get();
        $blogcategories = BlogCategory::all();
        $abouts = About::latest()->take(1)->get();
        $services = Service::all();
        $contacts = Contact::all();
        $sociallinks = SocialLink::all();
        $landlords = Landlord::all();
        $units = PmsUnit::all();
        $statements = PmsStatement::with('property', 'tenant')->latest()->get();
        $pmstenants = PmsTenant::orderBy('id', 'desc')->with('unit','property')->get();
        $pmsexpenses = PmsExpense::with('user')->latest()->get();

        $recentblogs= Blog::with('category')->orderBy('id', 'DESC')->limit(6)->get();
        $homefeaturedproperties = Property::latest()->where('featured',1)->with('type','images')->where('status',1)->limit(6)->get();
        $recentproperties = Property::inRandomOrder()->with('type','images')->where('featured',0)->where('status',1)->limit(6)->get();
        $messages = Message::latest()->where('status',0)->with('user')->get();
        $displaymessages = Message::latest()->with('user')->where('status',0)->limit(3)->get();
        $projects = Project::all();
        $homeprojects = Project::where('featured',0)->limit(4)->get();
        $homeservices = Service::latest()->limit(6)->get();
        $featuredproject = Project::latest()->where('featured',1)->limit(1)->get();
        $openproperties = Property::latest()->with('type','images')->where('status',1)->get();
        $closedproperties = Property::latest()->with('type','images')->where('status',2)->get();

        //dashboard count
        $pmsPropertyCount = PmsProperty::all()->count();
        $pmsVacantPropertyCount = PmsUnit::where('status', 0)->count();
        $pmsRentedPropertyCount = PmsUnit::where('status', 1)->count();
        $usersCount = User::all()->count();
        $tenantsCount = PmsTenant::all()->count();
        $landlordsCount = Landlord::all()->count();

        return response()->json([
            "lists" => [
                'users' => $users,
                'properties' => $properties,
                'roles' => $roles,
                'categories' => $categories,
                'propertytypes' => $propertytypes,
                "conditions" => $conditions,
                'furnishings' => $furnishings,
                'locations' => $locations,
                'blogs' => $blogs,
                'blogcategories' => $blogcategories,
                'abouts' => $abouts,
                'services' => $services,
                'homeservices' => $homeservices,
                'contacts' => $contacts,
                'sociallinks' => $sociallinks,
                'saleproperties' => $saleproperties,
                'rentproperties' => $rentproperties,
                'featuredproperties' => $featuredproperties,
                'featuredblogs' => $featuredblogs,
                'recentblogs' => $recentblogs,
                'homefeaturedproperties' => $homefeaturedproperties,
                'recentproperties' => $recentproperties,
                'messages' =>$messages,
                'displaymessages' => $displaymessages,
                'projects' => $projects,
                'homeprojects' => $homeprojects,
                'featuredproject' => $featuredproject,
                'closedproperties' => $closedproperties,
                'openproperties' => $openproperties,
                'landlords' => $landlords,
                'pmsproperties' => $pmsproperties,
                'units' => $units,
                'pmstenants' => $pmstenants,
                'pmsexpenses' => $pmsexpenses,
                'statements' => $statements,

                'pmspropertycount' => $pmsPropertyCount,
                'pmsvacantpropertycount' => $pmsVacantPropertyCount,
                'pmsrentedpropertycount' => $pmsRentedPropertyCount,
                'userscount' => $usersCount,
                'landlordscount' => $landlordsCount,
                'tenantscount' => $tenantsCount

                
            ]
        ]);

    }
}
