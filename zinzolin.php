<?php
/*
* Plugin Name:       Zinzolin
* Plugin URI:        https://zinzolin.fr/
* Description:       Zinzolin’s configuration file.
* Version:           1.0
* Requires at least: 6.2
* Requires PHP:      8.2
* Author:            Anhony Nelzin-Santos
* Author URI:        https://anthony.nelzin.fr/
* License:           EUPL v1.2
* License URI:       https://joinup.ec.europa.eu/collection/eupl/eupl-text-eupl-12
* Update URI:        https://example.com/zinzolin/
* Text Domain:       zinzolin
* Domain Path:       /languages
*/

/***********************************************
* Remove "/category/" from category permalinks *
***********************************************/

function zinzolin_remove_category_base($string, $type) {
	if ($type != "single" && $type == "category" && (strpos($string, "category") !== false)) {
		// Will NOT work with sub-categories
		return str_replace("/category/", "/", $string);
	}
	return $string;
}
add_filter("user_trailingslashit", "zinzolin_remove_category_base", 100, 2);

/*************************
* Make tags hierarchical *
*************************/

function zinzolin_register_hierarchical_tags() {
	// Override the default base with "/sur/"
	// whilst keeping the built-in rewriting capabilities
	global $wp_rewrite;
	$rewrite = array(
		"ep_mask"      => EP_TAGS,
		"hierarchical" => false,
		"slug"         => get_option("tag_base") ? get_option("tag_base") : "sur",
		"with_front"   => ! get_option("tag_base") || $wp_rewrite->using_index_permalinks(),
	);

	// Override default labels
	$labels = array(
		"name"                       => _x("Sujets", "Taxonomy General Name"),
		"singular_name"              => _x("Sujet", "Taxonomy Singular Name"),
		"menu_name"                  => __("Sujets"),
		"all_items"                  => __("Tous les sujets"),
		"add_new_item"               => __("Ajouter un nouveau sujet"),
		"add_or_remove_items"        => __("Add or remove tags"),
		"choose_from_most_used"      => __("Choose from the most used"),
		"edit_item"                  => __("Modifier le sujet"),
		"new_item_name"              => __("Nom du nouveau sujet"),
		"not_found"                  => __("Pas de sujet"),
		"parent_item"                => __("Sujet parent"),
		"parent_item_colon"          => __("Sujet parent:"),
		"popular_items"              => __("Sujets récurrents"),
		"search_items"               => __("Chercher parmi les sujets"),
		"separate_items_with_commas" => __("Séparer les sujets par des virgules"),
		"update_item"                => __("Revoir le sujet"),
		"view_item"                  => __("Voir le sujet"),
	);

	// Setup behaviour
	$args = array(
		"_builtin"          => true,
		"hierarchical"      => true, // Make the tags hierarchical
		"labels"            => $labels,
		"public"            => true,
		"query_var"         => "tag",
		"rewrite"           => $rewrite,
		"show_admin_column" => true,
		"show_in_menu"      => true,
		"show_in_nav_menus" => true,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	// Register taxonomy in the "post" type
	register_taxonomy("post_tag", ["post"], $args);
}
add_action("init", "zinzolin_register_hierarchical_tags");

/*****************************
* Register custom taxonomies *
*****************************/

function zinzolin_register_taxonomy_par() {
	// Setup labels
	$labels = array(
		"name"              => _x("Par", "Taxonomy General Name"),
		"singular_name"     => _x("Par", "Taxonomy Singular Name"),
		"add_new_item"      => __("Ajouter un nouvel auteur"),
		"all_items"         => __("Tous les auteurs"),
		"edit_item"         => __("Modifier l’auteur"),
		"menu_name"         => __("Auteurs"),
		"new_item_name"     => __("Nom du nouvel auteur"),
		"not_found"         => __("Pas d’auteur"),
		"parent_item"       => null,
		"parent_item_colon" => null,
		"search_items"      => __("Chercher parmi les auteurs"),
		"update_item"       => __("Revoir l’auteur"), 
	);

	// Setup behaviour
	$args = array(
		"hierarchical"      => false,
		"labels"            => $labels,
		"query_var"         => true,
		"rewrite"           => ["slug" => "par"],
		"show_admin_column" => false,
		"show_in_menu"      => true,
		"show_in_nav_menus" => false,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	// Register taxonomy in the "post" type
	register_taxonomy("par", ["post"], $args);
}
add_action("init", "zinzolin_register_taxonomy_par");

function zinzolin_register_taxonomy_chez() {
	// Setup labels
	$labels = array(
		"name"              => _x("Chez", "Taxonomy General Name"),
		"singular_name"     => _x("Chez", "Taxonomy Singular Name"),
		"add_new_item"      => __("Ajouter un nouvel éditeur"),
		"all_items"         => __("Tous les éditeurs"),
		"edit_item"         => __("Modifier l’éditeur"),
		"menu_name"         => __("Éditeurs"),
		"new_item_name"     => __("Nom du nouvel éditeur"),
		"not_found"         => __("Pas d’éditeur"),
		"parent_item"       => null,
		"parent_item_colon" => null,
		"search_items"      => __("Chercher parmi les éditeurs"),
		"update_item"       => __("Revoir l’éditeur"),
	);

	// Setup behaviour
	$args = array(
		"hierarchical"      => false,
		"labels"            => $labels,
		"query_var"         => true,
		"rewrite"           => ["slug" => "chez"],
		"show_admin_column" => false,
		"show_in_menu"      => true,
		"show_in_nav_menus" => false,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	// Register taxonomy in the "post" type
	register_taxonomy("chez", ["post"], $args);
}
add_action("init", "zinzolin_register_taxonomy_chez");

function zinzolin_register_taxonomy_dans() {
	// Setup labels
	$labels = array(
		"name"              => _x("Dans", "Taxonomy General Name"),
		"singular_name"     => _x("Dans", "Taxonomy Singular Name"),
		"add_new_item"      => __("Ajouter un nouvel emplacement"),
		"all_items"         => __("Tous les emplacements"),
		"edit_item"         => __("Modifier l’emplacement"),
		"menu_name"         => __("Emplacements"),
		"new_item_name"     => __("Nom du nouvel emplacement"),
		"not_found"         => __("Pas d’emplacement"),
		"parent_item"       => null,
		"parent_item_colon" => null,
		"search_items"      => __("Chercher parmi les emplacements"),
		"update_item"       => __("Revoir l’emplacement"), 
	);

	// Setup behaviour
	$args = array(
		"hierarchical"      => false,
		"labels"            => $labels,
		"query_var"         => true,
		"rewrite"           => ["slug" => "dans"],
		"show_admin_column" => false,
		"show_in_menu"      => true,
		"show_in_nav_menus" => false,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	register_taxonomy("dans", ["post"], $args);
}
add_action("init", "zinzolin_register_taxonomy_dans");

function zinzolin_register_taxonomy_genre() {
	// Setup labels
	$labels = array(
		"name"              => _x("Genre", "Taxonomy General Name"),
		"singular_name"     => _x("Genre", "Taxonomy Singular Name"),
		"add_new_item"      => __("Ajouter un nouveau genre"),
		"all_items"         => __("Tous les genres"),
		"edit_item"         => __("Modifier le genre"),
		"menu_name"         => __("Genres"),
		"new_item_name"     => __("Nom du nouveau genre"),
		"not_found"         => __("Pas de genre"),
		"parent_item"       => null,
		"parent_item_colon" => null,
		"search_items"      => __("Chercher parmi les genres"),
		"update_item"       => __("Revoir le genre"), 
	);

	// Setup behaviour
	$args = array(
		"hierarchical"      => false,
		"labels"            => $labels,
		"query_var"         => true,
		"rewrite"           => ["slug" => "genre"],
		"show_admin_column" => false,
		"show_in_menu"      => true,
		"show_in_nav_menus" => false,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	// Register taxonomy in the "post" type
	register_taxonomy("genre", ["post"], $args);
}
add_action("init", "zinzolin_register_taxonomy_genre");

function zinzolin_register_taxonomy_lu() {
	// Setup labels
	$labels = array(
		"name"              => _x("Lu", "Taxonomy General Name"),
		"singular_name"     => _x("Lu", "Taxonomy Singular Name"),
		"add_new_item"      => __("Ajouter un nouvelle lecture"),
		"all_items"         => __("Toutes les lectures"),
		"edit_item"         => __("Modifier la lecture"),
		"menu_name"         => __("Lectures"),
		"new_item_name"     => __("Nom de la nouvelle lecture"),
		"not_found"         => __("Pas de lecture"),
		"parent_item"       => null,
		"parent_item_colon" => null,
		"search_items"      => __("Chercher parmi les lectures"),
		"update_item"       => __("Revoir la lecture"), 
	);

	// Setup behaviour
	$args = array(
		"hierarchical"      => false,
		"labels"            => $labels,
		"query_var"         => true,
		"rewrite"           => ["slug" => "lu"],
		"show_admin_column" => false,
		"show_in_menu"      => true,
		"show_in_nav_menus" => false,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	// Register taxonomy in the "post" type
	register_taxonomy("lu", ["post"], $args);
}
add_action("init", "zinzolin_register_taxonomy_lu");

function zinzolin_register_taxonomy_de() {
	// Setup labels
	$labels = array(
		"name"              => _x("De", "Taxonomy General Name"),
		"singular_name"     => _x("De", "Taxonomy Singular Name"),
		"add_new_item"      => __("Ajouter un nouveau pays"),
		"all_items"         => __("Tous les pays"),
		"edit_item"         => __("Modifier le pays"),
		"menu_name"         => __("Pays"),
		"new_item_name"     => __("Nom du nouveau pays"),
		"not_found"         => __("Pas de pays"),
		"parent_item"       => null,
		"parent_item_colon" => null,
		"search_items"      => __("Chercher parmi les pays"),
		"update_item"       => __("Revoir le pays"), 
	);

	// Setup behaviour
	$args = array(
		"hierarchical"      => false,
		"labels"            => $labels,
		"query_var"         => true,
		"rewrite"           => ["slug" => "de"],
		"show_admin_column" => false,
		"show_in_menu"      => true,
		"show_in_nav_menus" => false,
		"show_in_rest"      => true, // Needed by the Gutenberg editor
		"show_ui"           => true,
	);

	// Register taxonomy in the "post" type
	register_taxonomy("de", ["post"], $args);
}
add_action("init", "zinzolin_register_taxonomy_de");