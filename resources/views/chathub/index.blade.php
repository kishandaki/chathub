<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat HUB</title>
  <link rel="stylesheet" href="{{ asset('assets/css/chathub.css') }}" />
</head>
<body class="chathub-page" data-user-initials="{{ $currentUser['initials'] }}">
  <main class="chathub-app">
    <aside class="chathub-panel chathub-rail">
      <button class="chathub-logo" aria-label="Chat HUB home">CH</button>
      <nav class="chathub-nav" aria-label="Main">
        <button class="chathub-nav-btn active" aria-label="Messages"><svg viewBox="0 0 24 24" fill="none"><path d="M5 6.8A3.8 3.8 0 0 1 8.8 3h6.4A3.8 3.8 0 0 1 19 6.8v5.4a3.8 3.8 0 0 1-3.8 3.8H11l-5.3 4.2c-.66.52-1.7.05-1.7-.79V6.8Z" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/></svg></button>
        <button class="chathub-nav-btn" aria-label="Teams"><svg viewBox="0 0 24 24" fill="none"><path d="M8.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM17 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM2.5 21a6 6 0 0 1 12 0M14.5 21a5 5 0 0 1 7-4.58" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg></button>
        <button class="chathub-nav-btn" aria-label="Files"><svg viewBox="0 0 24 24" fill="none"><path d="M7 3h6l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><path d="M13 3v5h5M8.5 13h7M8.5 16.5h5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg></button>
        <button class="chathub-nav-btn" aria-label="Security"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3.2 5 6v5.3c0 4.4 2.9 7.7 7 9.5 4.1-1.8 7-5.1 7-9.5V6l-7-2.8Z" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/><path d="m9.4 12 1.8 1.8 3.8-4.2" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg></button>
      </nav>
      <div class="chathub-rail-bottom">
        <button class="chathub-nav-btn" id="chathubThemeToggle" aria-label="Toggle theme"><svg viewBox="0 0 24 24" fill="none"><path d="M21 14.5A8.2 8.2 0 0 1 9.5 3a8.8 8.8 0 1 0 11.5 11.5Z" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/></svg></button>
        <button class="chathub-nav-btn" aria-label="Profile"><svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4.2 4.2 0 1 0 0-8.4 4.2 4.2 0 0 0 0 8.4ZM4 21a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg></button>
      </div>
    </aside>

    <aside class="chathub-panel chathub-sidebar">
      <header class="chathub-side-head">
        <div class="chathub-label"><span class="chathub-live-dot"></span> Live workspace</div>
        <div class="chathub-side-title">
          <div>
            <h1>Chat HUB</h1>
            <p>Secure employee conversations, files, real-time status, and controlled admin recovery.</p>
          </div>
          <button class="chathub-primary-icon" id="chathubOpenModal" aria-label="Create chat"><svg viewBox="0 0 24 24" width="21" height="21" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
        </div>
        <label class="chathub-search">
          <svg viewBox="0 0 24 24" fill="none"><path d="m21 21-4.35-4.35M10.8 18.2a7.4 7.4 0 1 1 0-14.8 7.4 7.4 0 0 1 0 14.8Z" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg>
          <input id="chathubSearchInput" type="search" placeholder="Search people, groups, messages" />
        </label>
      </header>

      <div class="chathub-tabs">
        <button class="chathub-tab active" data-filter="all">All</button>
        <button class="chathub-tab" data-filter="unread">Unread</button>
        <button class="chathub-tab" data-filter="group">Groups</button>
        <button class="chathub-tab" data-filter="secure">Secure</button>
      </div>

      <section class="chathub-thread-list" id="chathubThreadList">
        @foreach ($conversations as $conversation)
          <button
            class="chathub-thread{{ $conversation['active'] ? ' active' : '' }}"
            data-name="{{ $conversation['name'] }}"
            data-role="{{ $conversation['role'] }}"
            data-avatar="{{ $conversation['avatar'] }}"
            data-color="{{ $conversation['color'] }}"
            data-tags="{{ implode(' ', $conversation['tags']) }}"
          >
            <span class="chathub-avatar {{ $conversation['color'] }}">{{ $conversation['avatar'] }}<span class="chathub-presence {{ $conversation['presence'] === 'idle' ? 'idle' : ($conversation['presence'] === 'offline' ? 'offline' : '') }}"></span></span>
            <span class="chathub-thread-main">
              <strong>{{ $conversation['name'] }}{{ $conversation['secure'] ? ' 🔒' : '' }}</strong>
              <p>{{ $conversation['preview'] }}</p>
            </span>
            <span class="chathub-thread-meta">
              <span>{{ $conversation['time'] }}</span>
              @if ($conversation['unread'] > 0)
                <span class="chathub-badge">{{ $conversation['unread'] }}</span>
              @endif
            </span>
          </button>
        @endforeach
      </section>
    </aside>

    <section class="chathub-panel chathub-main-chat">
      <header class="chathub-chat-head">
        <div class="chathub-chat-person">
          <span class="chathub-avatar {{ $activeConversation['color'] }}" id="chathubActiveAvatar">{{ $activeConversation['avatar'] }}<span class="chathub-presence"></span></span>
          <div>
            <h2 id="chathubActiveName">{{ $activeConversation['name'] }}</h2>
            <p id="chathubActiveRole"><span class="chathub-live-dot"></span> {{ $activeConversation['role'] }}</p>
          </div>
        </div>
        <div class="chathub-head-actions">
          <button class="chathub-icon-btn hide-mobile" aria-label="Search chat"><svg viewBox="0 0 24 24" fill="none"><path d="m21 21-4.35-4.35M10.8 18.2a7.4 7.4 0 1 1 0-14.8 7.4 7.4 0 0 1 0 14.8Z" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg></button>
          <button class="chathub-icon-btn hide-mobile" aria-label="Call"><svg viewBox="0 0 24 24" fill="none"><path d="M7 7.6 9.4 10a2 2 0 0 1 .3 2.4l-.8 1.35a10.2 10.2 0 0 0 4.35 4.35l1.35-.8a2 2 0 0 1 2.4.3l2.4 2.4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
          <button class="chathub-icon-btn" aria-label="More"><svg viewBox="0 0 24 24" fill="none"><path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM19 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2ZM5 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></button>
        </div>
      </header>

      <div class="chathub-security-strip">
        <strong>🔐 End-to-end encryption enabled</strong>
        <span>Admin recovery needs reason, approval, scope, and audit log.</span>
      </div>

      <div class="chathub-messages" id="chathubMessages">
        <div class="chathub-date-chip">Today</div>

        @foreach ($messages as $message)
          <article class="chathub-message{{ $message['mine'] ? ' mine' : '' }}">
            <span class="chathub-small-avatar">{{ $message['avatar'] }}</span>
            <div class="chathub-bubble">
              <span class="chathub-sender">{{ $message['sender'] }}</span>
              <p>{{ $message['text'] }}</p>
              @if (!empty($message['attachment']))
                <div class="chathub-attachment">
                  <span class="chathub-file-type">{{ $message['attachment']['type'] }}</span>
                  <span><strong>{{ $message['attachment']['name'] }}</strong><span>{{ $message['attachment']['meta'] }}</span></span>
                </div>
              @endif
              <div class="chathub-meta"><span>{{ $message['time'] }}</span><span>{{ $message['status'] }}</span></div>
            </div>
          </article>
        @endforeach
      </div>

      <div class="chathub-typing">
        <span>Kavya is typing</span>
        <span class="chathub-typing-dots"><i></i><i></i><i></i></span>
      </div>

      <footer class="chathub-composer">
        <div class="chathub-composer-box">
          <button class="chathub-icon-btn" aria-label="Emoji">☺</button>
          <input id="chathubMessageInput" type="text" placeholder="Write an encrypted message..." />
          <button class="chathub-icon-btn" aria-label="Attach">📎</button>
          <button class="chathub-send" id="chathubSendBtn" aria-label="Send"><svg viewBox="0 0 24 24" width="21" height="21" fill="none"><path d="M21 3 10.5 13.5M21 3l-6.6 18-3.9-7.5L3 9.6 21 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        </div>
      </footer>
    </section>
  </main>

  <nav class="chathub-panel chathub-bottom-nav">
    <button class="chathub-nav-btn active" aria-label="Messages">💬</button>
    <button class="chathub-nav-btn" aria-label="Teams">👥</button>
    <button class="chathub-nav-btn" aria-label="Files">📁</button>
    <button class="chathub-nav-btn" aria-label="Security">🔐</button>
    <button class="chathub-nav-btn" aria-label="Profile">👤</button>
  </nav>

  <div class="chathub-toast" id="chathubToast"><span class="chathub-toast-icon">✓</span><span id="chathubToastText">Message sent securely</span></div>

  <div class="chathub-modal-backdrop" id="chathubModal">
    <section class="chathub-modal">
      <div class="chathub-modal-head">
        <div>
          <h3>Start a conversation</h3>
          <p>Select the type of chat you want to create.</p>
        </div>
        <button class="chathub-icon-btn" id="chathubCloseModal" aria-label="Close">×</button>
      </div>
      <div class="chathub-modal-options">
        <button class="chathub-modal-option"><span class="chathub-modal-icon">👤</span><span><strong>Direct message</strong><span>Start a secure one-to-one chat.</span></span></button>
        <button class="chathub-modal-option"><span class="chathub-modal-icon">👥</span><span><strong>Group conversation</strong><span>Add members, files, and security rules.</span></span></button>
        <button class="chathub-modal-option"><span class="chathub-modal-icon">🏢</span><span><strong>Department channel</strong><span>Create an auto-managed team space.</span></span></button>
      </div>
    </section>
  </div>

  <script src="{{ asset('assets/js/chathub.js') }}"></script>
</body>
</html>
