<div class="auth-logo">
  <a href="{{ route('login') }}" class="logo-link" aria-label="Chat HUB home">
    <svg class="logo-svg" viewBox="0 0 320 120" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <defs>
        <linearGradient id="chathubGradient" x1="0%" y1="0%" x2="100%" y2="100%">
          <stop offset="0%" stop-color="#3549CE" />
          <stop offset="50%" stop-color="#7A5CFF" />
          <stop offset="100%" stop-color="#22C7E8" />
        </linearGradient>
      </defs>

      <g class="logo-mark">
        <circle class="hub-ring" cx="60" cy="60" r="34" fill="none" stroke="url(#chathubGradient)" stroke-width="6" />

        <line class="network-line" x1="60" y1="60" x2="40" y2="42" />
        <line class="network-line" x1="60" y1="60" x2="82" y2="42" />
        <line class="network-line" x1="60" y1="60" x2="60" y2="30" />
        <line class="network-line" x1="60" y1="60" x2="40" y2="80" />
        <line class="network-line" x1="60" y1="60" x2="82" y2="80" />

        <circle class="hub-core" cx="60" cy="60" r="8" fill="url(#chathubGradient)" />
        <circle class="node node-1" cx="40" cy="42" r="5" fill="url(#chathubGradient)" />
        <circle class="node node-2" cx="82" cy="42" r="5" fill="url(#chathubGradient)" />
        <circle class="node node-3" cx="60" cy="30" r="5" fill="url(#chathubGradient)" />
        <circle class="node node-4" cx="40" cy="80" r="5" fill="url(#chathubGradient)" />
        <circle class="node node-5" cx="82" cy="80" r="5" fill="url(#chathubGradient)" />
      </g>

      <text x="120" y="72" class="wordmark">Chat HUB</text>
    </svg>
  </a>
</div>