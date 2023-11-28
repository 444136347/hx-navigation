<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection show_outside
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection sub_title
     * @property Grid\Column|Collection cover_at
     * @property Grid\Column|Collection origin
     * @property Grid\Column|Collection content_id
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection city_id
     * @property Grid\Column|Collection verify_status
     * @property Grid\Column|Collection praise_counts
     * @property Grid\Column|Collection collection_counts
     * @property Grid\Column|Collection comment_counts
     * @property Grid\Column|Collection tag_id
     * @property Grid\Column|Collection article_id
     * @property Grid\Column|Collection picture_id
     * @property Grid\Column|Collection exclusive
     * @property Grid\Column|Collection use_num
     * @property Grid\Column|Collection video_id
     * @property Grid\Column|Collection key
     * @property Grid\Column|Collection string_value
     * @property Grid\Column|Collection text_value
     * @property Grid\Column|Collection text
     * @property Grid\Column|Collection link
     * @property Grid\Column|Collection depth
     * @property Grid\Column|Collection site_id
     * @property Grid\Column|Collection url
     * @property Grid\Column|Collection is_content
     * @property Grid\Column|Collection classify
     * @property Grid\Column|Collection contact
     * @property Grid\Column|Collection submit_ip
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection desc
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection video_at
     * @property Grid\Column|Collection seconds
     *
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection show_outside(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection sub_title(string $label = null)
     * @method Grid\Column|Collection cover_at(string $label = null)
     * @method Grid\Column|Collection origin(string $label = null)
     * @method Grid\Column|Collection content_id(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection city_id(string $label = null)
     * @method Grid\Column|Collection verify_status(string $label = null)
     * @method Grid\Column|Collection praise_counts(string $label = null)
     * @method Grid\Column|Collection collection_counts(string $label = null)
     * @method Grid\Column|Collection comment_counts(string $label = null)
     * @method Grid\Column|Collection tag_id(string $label = null)
     * @method Grid\Column|Collection article_id(string $label = null)
     * @method Grid\Column|Collection picture_id(string $label = null)
     * @method Grid\Column|Collection exclusive(string $label = null)
     * @method Grid\Column|Collection use_num(string $label = null)
     * @method Grid\Column|Collection video_id(string $label = null)
     * @method Grid\Column|Collection key(string $label = null)
     * @method Grid\Column|Collection string_value(string $label = null)
     * @method Grid\Column|Collection text_value(string $label = null)
     * @method Grid\Column|Collection text(string $label = null)
     * @method Grid\Column|Collection link(string $label = null)
     * @method Grid\Column|Collection depth(string $label = null)
     * @method Grid\Column|Collection site_id(string $label = null)
     * @method Grid\Column|Collection url(string $label = null)
     * @method Grid\Column|Collection is_content(string $label = null)
     * @method Grid\Column|Collection classify(string $label = null)
     * @method Grid\Column|Collection contact(string $label = null)
     * @method Grid\Column|Collection submit_ip(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection desc(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection video_at(string $label = null)
     * @method Grid\Column|Collection seconds(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection status
     * @property Show\Field|Collection show_outside
     * @property Show\Field|Collection type
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection content
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection sub_title
     * @property Show\Field|Collection cover_at
     * @property Show\Field|Collection origin
     * @property Show\Field|Collection content_id
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection city_id
     * @property Show\Field|Collection verify_status
     * @property Show\Field|Collection praise_counts
     * @property Show\Field|Collection collection_counts
     * @property Show\Field|Collection comment_counts
     * @property Show\Field|Collection tag_id
     * @property Show\Field|Collection article_id
     * @property Show\Field|Collection picture_id
     * @property Show\Field|Collection exclusive
     * @property Show\Field|Collection use_num
     * @property Show\Field|Collection video_id
     * @property Show\Field|Collection key
     * @property Show\Field|Collection string_value
     * @property Show\Field|Collection text_value
     * @property Show\Field|Collection text
     * @property Show\Field|Collection link
     * @property Show\Field|Collection depth
     * @property Show\Field|Collection site_id
     * @property Show\Field|Collection url
     * @property Show\Field|Collection is_content
     * @property Show\Field|Collection classify
     * @property Show\Field|Collection contact
     * @property Show\Field|Collection submit_ip
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection desc
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection video_at
     * @property Show\Field|Collection seconds
     *
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection show_outside(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection sub_title(string $label = null)
     * @method Show\Field|Collection cover_at(string $label = null)
     * @method Show\Field|Collection origin(string $label = null)
     * @method Show\Field|Collection content_id(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection city_id(string $label = null)
     * @method Show\Field|Collection verify_status(string $label = null)
     * @method Show\Field|Collection praise_counts(string $label = null)
     * @method Show\Field|Collection collection_counts(string $label = null)
     * @method Show\Field|Collection comment_counts(string $label = null)
     * @method Show\Field|Collection tag_id(string $label = null)
     * @method Show\Field|Collection article_id(string $label = null)
     * @method Show\Field|Collection picture_id(string $label = null)
     * @method Show\Field|Collection exclusive(string $label = null)
     * @method Show\Field|Collection use_num(string $label = null)
     * @method Show\Field|Collection video_id(string $label = null)
     * @method Show\Field|Collection key(string $label = null)
     * @method Show\Field|Collection string_value(string $label = null)
     * @method Show\Field|Collection text_value(string $label = null)
     * @method Show\Field|Collection text(string $label = null)
     * @method Show\Field|Collection link(string $label = null)
     * @method Show\Field|Collection depth(string $label = null)
     * @method Show\Field|Collection site_id(string $label = null)
     * @method Show\Field|Collection url(string $label = null)
     * @method Show\Field|Collection is_content(string $label = null)
     * @method Show\Field|Collection classify(string $label = null)
     * @method Show\Field|Collection contact(string $label = null)
     * @method Show\Field|Collection submit_ip(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection desc(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection video_at(string $label = null)
     * @method Show\Field|Collection seconds(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
