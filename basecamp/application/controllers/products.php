<?
/*	CREATED BY:
 *         ___      _ __________          _ ____ _____ _____
 *    ___ / _ \  __| |___ /___  |_      _/ | ___|___  |___ / _ __
 *   / __| | | |/ _` | |_ \  / /\ \ /\ / / |___ \  / /  |_ \| '__|
 *  | (__| |_| | (_| |___) |/ /  \ V  V /| |___) |/ /  ___) | | _
 * (_)___|\___/ \__,_|____//_/    \_/\_/ |_|____//_/  |____/|_|(_)
 * 
*/

class Products extends MY_Controller {

    function Products() {
        parent::MY_Controller();
        $this->load->library('Review');
    }

    function index() {

    }

    function change_sort_column() {
        $sorting = mysql_real_escape_string($this->input->post('sorting'));
        $this->load->library('ProductFilters');
        $this->productfilters->setFilterValue("sort_column", $sorting);
        $from_page = $_SERVER["HTTP_REFERER"];
        redirect($from_page, 'location');
    }

    function apply_filters() {

        $from_price = mysql_real_escape_string($this->input->post('from_price'));
        $to_price = mysql_real_escape_string($this->input->post('to_price'));
        $in_stock = mysql_real_escape_string($this->input->post('in_stock'));
        $special_offer = mysql_real_escape_string($this->input->post('special_offer'));
        $producer = mysql_real_escape_string($this->input->post('producer'));
        $search_string = mysql_real_escape_string($this->input->post('search_string'));

        $this->load->library('ProductFilters');
        $this->productfilters->setFilterValue("from_price", $from_price);
        $this->productfilters->setFilterValue("to_price", $to_price);
        $this->productfilters->setFilterValue("in_stock", $in_stock?true:false);
        $this->productfilters->setFilterValue("special_offer", $special_offer?true:false);
        $this->productfilters->setFilterValue("producer", $producer);
        $this->productfilters->setFilterValue("search_string", $search_string);

        $from_page = $_SERVER["HTTP_REFERER"];
        redirect($from_page, 'location');
    }

    function delete_filter($filter_name) {
        $this->load->library('ProductFilters');
        $this->productfilters->unsetFilter($filter_name);
        $from_page = $_SERVER["HTTP_REFERER"];
        redirect($from_page, 'location');
    }

    function set_products_per_page() {
        $products_per_page = mysql_real_escape_string($this->input->post('products_per_page'));
        $this->session->set_userdata('products_per_page', $products_per_page);
        $from_page = $_SERVER["HTTP_REFERER"];
        redirect($from_page, 'location');
    }

    function show_prod($cat_id = 0, $cat_name = "-", $prod_id = 0, $prod_name = "-") {
        // type = c|p (categorie|product)
        $this->load->helper('misc_helper');
        // TODO trebuie sa facem ceva cu produsele si categoriile (o functie generala care scoate din baza de date)
        // si sa avem grija in functia asta sa bagam numa alea care-s pe limba selectata...
        // sa nu-i dam voie sa salveze produsele fara denumirea setata in limba default
        if ($prod_id > 0) {
            // scoatem produsul
            // suntem pe produs
            $this->load->model('Productmodel');
            $this->Productmodel->load_product($prod_id);
            $data["product_model"] = $this->Productmodel->return_array();
            $data["category_id"] = $cat_id;

            // opinia cumparatorilor
            $data["reviews"] = $this->review->getReviewsForId($prod_id, true);

            // incarcam produse similare... deocamdta produse din aceasi categorie.. (de ex. 3)
            $data["similar_prods"] = $this->Productmodel->getProductList($cat_id, array(), 0, 3, "`p`.`id` != '$prod_id'");

            $page = "show_product";
        } else if ($cat_id > 0) {
            // suntem pe o categorie

            $this->load->library('pagination');
            $this->load->library('ProductFilters');
            $data["sort_column"] = $this->productfilters->getFilterValue("sort_column");
            $data["sort_column_values"] = $this->productfilters->getSortColumnValues();

            // scoatem filtrele active
            $data["active_filters"] = $this->productfilters->getTextArray();

            $query = $this->db->query("SELECT * FROM `categories` WHERE `id` = '$cat_id' ");
            $data["category"] = $query->row_array();
            $cat_lang = getCategoryLang($cat_id);
            $data["category"]["name"] = $cat_lang["name"];
            $data["category"]["description"] = $cat_lang["description"];

            $query = $this->db->query("SELECT * FROM `categories` WHERE `parent_id` = '$cat_id' ");
            $data["category"]["subcats"] = $query->result_array();
            foreach ($data["category"]["subcats"] as $k => $v) {
                $cat_lang = getCategoryLang($v["id"]);
                $data["category"]["subcats"][$k]["name"] = $cat_lang["name"];
                $data["category"]["subcats"][$k]["short_desc"] = $cat_lang["short_desc"];
                //scoatem numarul de produse care le contine subcategoria...
                $query = $this->db->query("SELECT
                                                COUNT(`prc`.`id`) as `c`
                                            FROM
                                                `products_re_categories` as `prc`
                                                LEFT JOIN `products` as `p`
                                                    ON (`prc`.`product_id` = `p`.`id`)
                                            WHERE
                                                `category_id` = '".$v["id"]."'
                                                AND `p`.`appear_on_site` = 'y'");
                $row = $query->row_array();
                $data["category"]["subcats"][$k]["products_count"] = $row["c"];
            }

            $this->load->model('Productmodel');

            $total_products = $this->Productmodel->countProducts($cat_id, $this->productfilters->getFilterValues());

            $products_per_page = $this->_get_products_per_page();
            $data["products_per_page"] = $products_per_page;
            $data["total_products"] = $total_products;

            $config['base_url'] = site_url("products/$cat_id/".url_title($data["category"]["name"]))."/page/";
            $config['total_rows'] = $total_products;
            $config['per_page'] = $products_per_page;
            $config["page_query_string"] = FALSE;
            $config['uri_segment'] = 5;

            $this->pagination->initialize($config);

            $data["pagination_links"] = $this->pagination->create_links();

            $ofset = ($this->pagination->cur_page-1) * $config['per_page'];
            $data["category"]["products"] = $this->Productmodel->getProductList($cat_id, $this->productfilters->getFilterValues(), $ofset, $products_per_page);
            $data["products_count"] = count($data["category"]["products"]);
            $data["language_id"] = $this->lang_id;

            // scoatem producatorii
            $query = $this->db->query("SELECT * FROM `producers` WHERE 1");
            $producers = $query->result_array();
            $data["producers_dropdown"][0] = " - alege producator - ";
            foreach ($producers as $k => $v) {
                $data["producers_dropdown"][$v["id"]] = $v["name"];
            }

            $data["products_per_page_select"][10] = 10;
            $data["products_per_page_select"][20] = 20;
            $data["products_per_page_select"][30] = 30;

            $page = "show_category";
        }

        $this->setTemplateDataArr($data);
        $this->showMainTemplate($page);
    }

    function add_review($product_id) {
        $review_rating = mysql_real_escape_string($this->input->post('review_rating'));
        $review_desc = $this->input->post('review_desc');

        $this->review->addReview($product_id, $review_rating, $review_desc, $this->lang_id, $this->client_id);

        $from_page = $_SERVER["HTTP_REFERER"];
        redirect($from_page, 'location');
    }

    function _get_products_per_page() {
        $products_per_page = $this->session->userdata('products_per_page');
        if (!$products_per_page) {
            $products_per_page = 10;
        }
        return $products_per_page;
    }

}

?>