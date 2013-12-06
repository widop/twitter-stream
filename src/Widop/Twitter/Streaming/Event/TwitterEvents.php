<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\Twitter\Streaming\Event;

/**
 * Twitter events.
 *
 * @author Geoffrey Brier <geoffrey.brier@gmail.com>
 */
final class TwitterEvents
{
    const PUBLIC_EVENT = 'public.event';
    const PUBLIC_STATUS_NEW = 'public.status.new';
    const PUBLIC_STATUS_DELETED = 'public.status.deleted';
    const PUBLIC_USER_NEW = 'public.user.new';
    const PUBLIC_NOTICE_EVENT = 'public.notice.event';
    const PUBLIC_NOTICE_LOCATION_DELETED = 'public.notice.location_deleted';
    const PUBLIC_NOTICE_LIMIT = 'public.notice.limit';
    const PUBLIC_NOTICE_STATUS_WITHHELD = 'public.notice.status_withheld';
    const PUBLIC_NOTICE_USER_WITHHELD = 'public.notice.user_withheld';
    const PUBLIC_NOTICE_DISCONNECT = 'public.notice.disconnect';

    const NOTICE_EVENT = 'notice.event';
    const NOTICE_STALL_WARNING = 'notice.stall_warning';
    const NOTICE_FOLLOW_LIMIT = 'notice.follow_limit';

    const USER_EVENT = 'user.event';
    const USER_FRIEND_LIST = 'user.friend_list';
    const USER_DIRECT_MESSAGE = 'user.direct_message';
    const USER_EVENT_EVENT = 'user.event.event'; // UGLY
    const USER_PROFILE_UPDATE = 'user.profile_update';
    const USER_PROFILE_UPDATE_PROTECTED = 'user.profile_update_protected';

    const SITE_EVENT = 'site.event';
    const SITE_NOTICE_CONTROL_MESSAGE = 'site.notice.control_message';
}
