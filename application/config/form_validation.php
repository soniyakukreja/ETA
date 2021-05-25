 <?php 
$config = array(
        'login_step1' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email address',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),

        ),
        'login_step2' => array(
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required|xss_clean'
                ),
        ),
        'add_licensee' => array(
                array(
                        'field' => 'lic_number',
                        'label' => 'License number',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces'
                ),
                array(
                        'field' => 'lic_startdate',
                        'label' => 'License start date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lic_enddate',
                        'label' => 'License end date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'l_country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email|is_unique[user.email]'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[20]'
                ),
                array(
                        'field' => 'business_name',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                ),
                array(
                        'field' => 'category',
                        'label' => 'Category',
                        'rules' => 'trim|xss_clean'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required|trim|xss_clean|min_length[8]|max_length[128]'
                ),
                array(
                        'field' => 'cpassword',
                        'label' => 'Confirm Password',
                        'rules' => 'required|trim|xss_clean|min_length[8]|max_length[128]'
                )
                              
        ),
        'edit_lic' => array(
                array(
                        'field' => 'lic_number',
                        'label' => 'License number',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces'
                ),
                array(
                        'field' => 'lic_startdate',
                        'label' => 'License start date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lic_enddate',
                        'label' => 'License end date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'l_country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'business_name',
                        'label' => 'Business name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'address',
                        'label' => 'Business Address',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'suburb',
                        'label' => 'Suburb/Province',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'postcode',
                        'label' => 'Post Code',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ), 
        ),
        'add_ia' => array(
                array(
                        'field' => 'lic_number',
                        'label' => 'License number',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces'
                ),
                array(
                        'field' => 'lic_startdate',
                        'label' => 'License start date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lic_enddate',
                        'label' => 'License end date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'ia_country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email|is_unique[user.email]'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'business_name',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                ),array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required|trim|xss_clean|min_length[8]|max_length[128]'
                ),
                array(
                        'field' => 'cpassword',
                        'label' => 'Confirm Password',
                        'rules' => 'required|trim|xss_clean|min_length[8]|max_length[128]'
                )
                              
        ),
        'add_banner' => array(
                array(
                        'field' => 'ba_name',
                        'label' => 'Banner Name',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces'
                ),array(
                        'field' => 'ba_roles_id',
                        'label' => 'Intended User',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'ba_link',
                        'label' => 'Banner Link',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'ba_status',
                        'label' => 'Banner Status',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'ba_bannertype',
                        'label' => 'Banner Type',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'publish_date',
                        'label' => 'Publish Date',
                        'rules' => 'required|trim|xss_clean'
                )
        ),
        'add_page' => array(
                array(
                        'field' => 'pb_name',
                        'label' => 'Page Name',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces|max_length[255]'
                ),array(
                        'field' => 'pb_slug',
                        'label' => 'Page Slug',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'pb_role_id',
                        'label' => 'Intended User',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'pb_status',
                        'label' => 'Page Status',
                        'rules' => 'required|trim|xss_clean'
                )
                // ,array(
                //         'field' => 'pb_featureimage',
                //         'label' => 'Feature Image',
                //         'rules' => 'required|trim|xss_clean'
                // )
                // ,array(
                //         'field' => 'pb_cta_label',
                //         'label' => 'CTA Label',
                //         'rules' => 'required|trim|xss_clean'
                // ),array(
                //         'field' => 'pb_cta_text',
                //         'label' => 'CTA Text',
                //         'rules' => 'required|trim|xss_clean'
                // ),array(
                //         'field' => 'pb_publishdate',
                //         'label' => 'Publish Date',
                //         'rules' => 'required|trim|xss_clean'
                // )
        ),
        'add_staff' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email|is_unique[user.email]'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'dept',
                        'label' => 'Department',
                        'rules' => 'trim|xss_clean'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[128]'
                ),
                array(
                        'field' => 'cpassword',
                        'label' => 'Confirm Password',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[128]'
                )
                              
        ),

        'add_product' => array(
                array(
                        'field' => 'product_name',
                        'label' => 'Product Name',
                        'rules' => 'required|trim|xss_clean|is_unique[product.product_name]'
                ),
                // array(
                //         'field' => 'product_sku',
                //         'label' => 'Product SKU',
                //         'rules' => 'required|trim|xss_clean|alpha_numeric|min_length[8]|max_length[70]'
                // ),
                array(
                        'field' => 'prod_cat_id',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                // array(
                //         'field' => 'supplier_id',
                //         'label' => 'Supplier',
                //         'rules' => 'required|trim|xss_clean'
                // ),
                array(
                        'field' => 'type',
                        'label' => 'Type',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'wsale_price',
                        'label' => 'Wholesale Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'l_price',
                        'label' => 'Licensee Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'ia_price',
                        'label' => 'Industry Association Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'c_price',
                        'label' => 'Consumer Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                // array(
                //         'field' => 'prod_dis',
                //         'label' => 'Discount',
                //         'rules' => 'trim|xss_clean'
                // ),
                // array(
                //         'field' => 'prod_dis_startdate',
                //         'label' => 'Discount Start Dates',
                //         'rules' => 'trim|xss_clean'
                // ),
                // array(
                //         'field' => 'prod_dis_enddate',
                //         'label' => 'Discount End Dates',
                //         'rules' => 'trim|xss_clean'
                // ),
                array(
                        'field' => 'prod_status',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                ),
                array(
                        'field' => 'ck_form_id',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                )
                              
        ),

        'edit_ia' => array(
                array(
                        'field' => 'lic_number',
                        'label' => 'License number',
                        'rules' => 'required|trim|xss_clean|alpha_numeric'
                ),
                array(
                        'field' => 'lic_startdate',
                        'label' => 'License start date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lic_enddate',
                        'label' => 'License end date',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'category',
                        'label' => 'Category',
                        'rules' => 'trim|xss_clean'
                ),
                array(
                        'field' => 'ia_country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'business_name',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                )
                              
        ),

        'add_category' => array(
                array(
                        'field' => 'prod_cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

        'edit_category' => array(
                array(
                        'field' => 'prod_cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

        'edit_product' => array(
                array(
                        'field' => 'product_name',
                        'label' => 'Product Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                // array(
                //         'field' => 'product_sku',
                //         'label' => 'Product SKU',
                //         'rules' => 'required|trim|xss_clean|alpha_numeric|min_length[8]|max_length[70]'
                // ),
                array(
                        'field' => 'prod_cat_id',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                // array(
                //         'field' => 'supplier_id',
                //         'label' => 'Supplier',
                //         'rules' => 'required|trim|xss_clean'
                // ),
                array(
                        'field' => 'type',
                        'label' => 'Type',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'wsale_price',
                        'label' => 'Wholesale Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'l_price',
                        'label' => 'Licensee Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'ia_price',
                        'label' => 'Industry Association Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'c_price',
                        'label' => 'Consumer Price',
                        'rules' => 'required|trim|xss_clean'
                ),
                // array(
                //         'field' => 'prod_dis',
                //         'label' => 'Discount',
                //         'rules' => 'required|trim|xss_clean'
                // ),
                // array(
                //         'field' => 'prod_dis_startdate',
                //         'label' => 'Discount Start Dates',
                //         'rules' => 'trim|xss_clean'
                // ),
                // array(
                //         'field' => 'prod_dis_enddate',
                //         'label' => 'Discount End Dates',
                //         'rules' => 'trim|xss_clean'
                // ),
                array(
                        'field' => 'prod_status',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                ),
                array(
                        'field' => 'ck_form_id',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean'
                )
                              
        ),
        'add_note' => array(
                array(
                        'field' => 'app_activity_title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'app_activity_des',
                        'label' => 'Description',
                        'rules' => 'required|trim|xss_clean'
                ),
        ),
        'add_business' =>array(
                array(
                        'field' => 'bus_name',
                        'label' => 'Business name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'address',
                        'label' => 'Street Address',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'suburb',
                        'label' => 'Suburb',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'postcode',
                        'label' => 'Post Code',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
        ),
        'add_contactperson' =>array(
                array(
                        'field' => 'person',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean'
                ),              
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        //'rules' => 'required|trim|xss_clean|valid_email|is_unique[contact.contact_email]'
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Contact Number',
                        'rules' => 'required|xss_clean'
                ),
        ),

         'add_supplier' => array(

                array(
                        'field' => 'supplier_fname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'supplier_lname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                
                array(
                        'field' => 'supplier_country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'supplier_email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email|is_unique[user.email]'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'business_id',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean|required'
                )
                              
        ),

          'edit_supplier' => array(

                array(
                        'field' => 'supplier_fname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'supplier_lname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                
                 array(
                        'field' => 'supplier_country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'supplier_email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),
                array(
                        'field' => 'business_id',
                        'label' => 'Business name',
                        'rules' => 'trim|xss_clean|required'
                )
                              
        ),
        'edit_page' => array(
                array(
                        'field' => 'pb_name',
                        'label' => 'Page Name',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces'
                ),array(
                        'field' => 'pb_slug',
                        'label' => 'Page Slug',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'pb_role_id',
                        'label' => 'Intended User',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'pb_status',
                        'label' => 'Page Status',
                        'rules' => 'required|trim|xss_clean'
                )
                //,array(
                //         'field' => 'pb_featureimage_h',
                //         'label' => 'Feature Image',
                //         'rules' => 'required|trim|xss_clean'
                // ),array(
                //         'field' => 'pb_cta_label',
                //         'label' => 'CTA Label',
                //         'rules' => 'required|trim|xss_clean'
                // ),array(
                //         'field' => 'pb_cta_text',
                //         'label' => 'CTA Text',
                //         'rules' => 'required|trim|xss_clean'
                // ),array(
                //         'field' => 'pb_publishdate',
                //         'label' => 'Publish Date',
                //         'rules' => 'required|trim|xss_clean'
                // )
        ),
        'edit_banner' => array(
                array(
                        'field' => 'ba_name',
                        'label' => 'Banner Name',
                        'rules' => 'required|trim|xss_clean|alpha_numeric_spaces'
                ),
                //array(
                //         'field' => 'ba_image_h',
                //         'label' => 'Banner Image',
                //         'rules' => 'required|trim|xss_clean'
                // ),array(
                //         'field' => 'ba_roles_id',
                //         'label' => 'Intended User',
                //         'rules' => 'required|trim|xss_clean'
                // ),
                array(
                        'field' => 'ba_link',
                        'label' => 'Banner Link',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'ba_status',
                        'label' => 'Banner Status',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'ba_bannertype',
                        'label' => 'Banner Type',
                        'rules' => 'required|trim|xss_clean'
                ),array(
                        'field' => 'publish_date',
                        'label' => 'Publish Date',
                        'rules' => 'required|trim|xss_clean'
                )
        ),
         'edit_business' =>array(
                array(
                        'field' => 'bus_name',
                        'label' => 'Business name',
                        'rules' => 'required|trim|xss_clean'
                        // 'rules' => 'required|trim|xss_clean|is_unique[business.business_name]'
                ),
                array(
                        'field' => 'address',
                        'label' => 'Street Address',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'suburb',
                        'label' => 'Suburb',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'postcode',
                        'label' => 'Post Code',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
        ),
        'edit_contactperson' =>array(
                array(
                        'field' => 'person',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean'
                ),              
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'phone',
                        'label' => 'Contact Numer',
                        'rules' => 'required|trim|xss_clean'
                ),

        ),
        'addtocart'=>array(
            array(
                'field' => 'pid',
                'label' => 'Product ',
                'rules' => 'required|trim|xss_clean'
            ),
        ),
        'edit_staff' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'dept',
                        'label' => 'Department',
                        'rules' => 'trim|xss_clean'
                ),
               
                              
        ),
        'add_ticcategory' => array(
                array(
                        'field' => 'tic_cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

        'edit_ticcategory' => array(
                array(
                        'field' => 'tic_cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

         'add_ticket' => array(
                array(
                        'field' => 'tic_title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),


        'consumer_addticket' => array(
                array(
                        'field' => 'tic_title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'tic_cat_id',
                        'label' => 'Ticket Category',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'tic_desc',
                        'label' => 'Ticket Description',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

          'edit_ticket' => array(
                array(
                        'field' => 'tic_title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

        'add_ticnote' => array(
                array(
                        'field' => 'tic_activity_title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'tic_activity_type',
                        'label' => 'Type',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'tic_activity_des',
                        'label' => 'Description',
                        'rules' => 'required|trim|xss_clean'
                ),
        ),
        'add_order'=>array(
            array(
                    'field' => 'fname',
                    'label' => 'First Name',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'lname',
                    'label' => 'Last Name',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'email',
                    'label' => 'Email Address',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'address',
                    'label' => 'Address ',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'city',
                    'label' => 'City',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'state',
                    'label' => 'State',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'postcode',
                    'label' => 'Post Code',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'country',
                    'label' => 'Country',
                    'rules' => 'required|trim|xss_clean'
            ),
            // array(
            //         'field' => 'stripeToken',
            //         'label' => 'Stripe Token',
            //         'rules' => 'required|trim|xss_clean'
            // ),
            
            
        ),
        'add_deal'=>array(
            array(
                    'field' => 'deal_title',
                    'label' => 'Deal Title',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'deal_value',
                    'label' => 'Deal Value',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'stage',
                    'label' => 'Stage',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'close_date',
                    'label' => 'Expected Close Date',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'business_id',
                    'label' => 'Business',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'cp',
                    'label' => 'Contact Person',
                    'rules' => 'required|trim|xss_clean'
            ),
        ),
        'add_deal_with_cp_business'=>array(

            array(
                'field' => 'deal_title',
                'label' => 'Deal Title',
                'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'cp_name',
                    'label' => 'Contact Name',
                    'rules' => 'required|trim|xss_clean'
            ),              
            array(
                    'field' => 'email',
                    'label' => 'Contact Email',
                    'rules' => 'required|trim|xss_clean|valid_email|is_unique[contact.contact_email]'
            ),
            array(
                    'field' => 'phone',
                    'label' => 'Contact Number',
                    'rules' => 'required|xss_clean'
            ),
            array(
                    'field' => 'bus_name',
                    'label' => 'Business name',
                    'rules' => 'required|trim|xss_clean|is_unique[business.business_name]'
            ),
            array(
                    'field' => 'address',
                    'label' => 'Street Address',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'suburb',
                    'label' => 'Suburb/Province',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'postcode',
                    'label' => 'Post Code',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'country',
                    'label' => 'Country',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'deal_value',
                    'label' => 'Deal Value',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'stage',
                    'label' => 'Stage',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'close_date',
                    'label' => 'Expected Close Date',
                    'rules' => 'required|trim|xss_clean'
            ),
        ),
	   'edit_deal'=>array(
            array(
                    'field' => 'deal_title',
                    'label' => 'Deal Title',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'deal_value',
                    'label' => 'Deal Value',
                    'rules' => 'required|trim|xss_clean'
            ),
            array(
                    'field' => 'stage',
                    'label' => 'Stage',
                    'rules' => 'required|trim|xss_clean'
            ),
            
        ),
        'add_usercategory' => array(
                array(
                        'field' => 'user_cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'role_id',
                        'label' => 'Intended User',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),

        'edit_usercategory' => array(
                array(
                        'field' => 'user_cat_name',
                        'label' => 'Category Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'roles_id',
                        'label' => 'Intended User',
                        'rules' => 'required|trim|xss_clean'
                ),
         ),
        'doc_template'=>array(
            array(
                'field' => 'role_id',
                'label' => 'User Type',
                'rules' => 'required|trim'
            ),
        ),
        'email_template'=>array(
            // array(
            //     'field' => 'role_id',
            //     'label' => 'User Type',
            //     'rules' => 'required|trim|xss_clean'
            // ),
            array(
                'field' => 'subject',
                'label' => 'Subject ',
                'rules' => 'required|trim|xss_clean'
            ),
            array(
                'field' => 'email_body',
                'label' => 'Email Content',
                'rules' => 'required|trim|xss_clean'
            ),
        ),
        'add_consumer' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email|is_unique[user.email]'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[128]'
                ),
                array(
                        'field' => 'cpassword',
                        'label' => 'Confirm Password',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[128]'
                )
        ),
        'edit_consumer' => array(
                array(
                        'field' => 'firstname',
                        'label' => 'First name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'lastname',
                        'label' => 'Last name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),array(
                        'field' => 'country',
                        'label' => 'Country',
                        'rules' => 'required|trim|xss_clean'
                ),
        ),
        'update_profile'=>array(
                array(
                        'field' => 'contactno',
                        'label' => 'Contact no.',
                        'rules' => 'trim|xss_clean|min_length[8]|max_length[15]'
                ),
        ),
        'add_formtemp'=>array(
                array(
                        'field' => 'temp_name',
                        'label' => 'Template Name',
                        'rules' => 'required|trim|xss_clean'
                ), array(
                        'field' => 'frm_manager',
                        'label' => 'Form Fields',
                        'rules' => 'required|trim'
                ),
        ),

        'update_formtemp'=>array(
                array(
                        'field' => 'temp_name',
                        'label' => 'Template Name',
                        'rules' => 'required'
                ), array(
                        'field' => 'frm_manager',
                        'label' => 'Form Fields',
                        'rules' => 'required'
                ),
        ),
        'edit_licbusiness'=>array(
                array(
                        'field' => 'busrev_status',
                        'label' => 'Status',
                        'rules' => 'required|trim|xss_clean'
                )
        ),

        'edit_iabusiness'=>array(
                array(
                        'field' => 'busrev_status',
                        'label' => 'Status',
                        'rules' => 'required|trim|xss_clean'
                )
        ),

        'clogin_step2' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email address',
                        'rules' => 'required|trim|xss_clean|valid_email'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required|xss_clean'
                ),

        ),
        'addcompliance' => array(
                array(
                        'field' => 'business_id',
                        'label' => 'Company Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'l_country',
                        'label' => 'Country',
                        'rules' => 'required|xss_clean'
                ),

        ),

        'addaudience' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|xss_clean'
                ),

        ),

        'editaudience' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|xss_clean'
                ),

        ),

        'addaudit' => array(
                
                array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'required|trim|xss_clean'
                ),

        ),

        'editaudit' => array(
                array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'required|trim|xss_clean'
                ),

        ),
        'expressInt'=>array(
            array(
                'field' => 'pid',
                'label' => 'Product ',
                'rules' => 'required|trim|xss_clean'
            ),
        ),

        'edit_whisle' => array(
                array(
                        'field' => 'comp_tic_status',
                        'label' => 'Status',
                        'rules' => 'required|trim|xss_clean'
                ),

        ),
)
?>        