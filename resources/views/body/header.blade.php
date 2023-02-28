<header>
    <div>
        <span class="site-title">
            Web AIアドバイザー
        </span>
    </div>
    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">ログアウト</button>
        </form>
    </div>
    <div>いいね</div>
</header>