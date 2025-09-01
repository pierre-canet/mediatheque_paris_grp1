<?php

function admin_dashboard() {
    render_view('admin/dashboard');
}

function admin_media_list() {
    render_view('admin/media_list');
}

function admin_media_edit() {
    render_view('admin/media_edit');
}

function admin_users_list() {
    render_view('admin/users_list');
}

function admin_user_detail() {
    render_view('admin/user_detail');
}
