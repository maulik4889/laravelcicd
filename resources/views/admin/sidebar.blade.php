
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(https://matutto.com/backend/admin_assets/images/matutto.png);"></a>
	        <ul class="list-unstyled components mb-5">
	        
            <li class="{{ Request::path() == 'admin' ? 'active' : '' }}">
	            <a href="{{ route('admin.dashboard') }}"  ></span>Dashboard</a></li>
	         
            <li  class="{{ Request::path() == 'admin/manageUsers/students' ? 'actives' : '' }}">
                    <a href="{{ route('admin.students.list') }}">Users Management</a>
                </li>

            <li>
              <a href="{{ route('admin.pages.get') }}">Manage Pages</a>
	          </li>
            <li>
              <a  href="{{ route('admin.faq.get') }}">Manage Faqs</a>
	          </li>
          
            <!-- <li >
              <a href="{{ route('admin.coupons.get') }}">Promo Codes</a>
	          </li> -->

            <!-- <li class="{{ Request::path() == 'admin/managePayments' ? 'active' : '' }}">
              <a href="{{ route('admin.payments.list','all') }}">Manage Payments</a>
	          </li> -->
           
            <!-- <li class="{{ Request::path() == 'admin/manageEmails/getEmailForm' ? 'active' : '' }}">
              <a href="{{ route('admin.email.send') }}">Send Emails</a>
	          </li> -->
      
            <li class="{{ Request::path() == 'admin/manageBlogs' ? 'active' : '' }}">
              <a href="{{ route('admin.blogs.get','all') }}">Manage Blogs</a>
	          </li>
            <!-- <li class="{{ Request::path() == 'admin/manageNews' ? 'active' : '' }}">
              <a href="{{ route('admin.news.get','all') }}">Manage News</a>
	          </li> -->
	        </ul>
   

	      </div>
    	</nav>

        <!-- Page Content  -->
     