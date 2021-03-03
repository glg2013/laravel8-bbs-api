<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function destroy(User $user, Reply $reply)
    {
        // 回复的作者 或者 帖子的作者 都可以删除回复
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
