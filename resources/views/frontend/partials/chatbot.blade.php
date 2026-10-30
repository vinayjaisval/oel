@php
    $chatbot_logo = asset('frontend/img/chatbot-logo.png');
    $chatbot_robot = asset('frontend/img/chatbot-robot.png');
    $chatbot_api_url = env('CHATBOT_API_URL', 'https://smebuzz.com/chatbots/api/overseaseducationlane/chat');
@endphp
<!-- Overseas Education Lane AI Chatbot Widget -->
<style>
#oel-chatbot-wrapper { position: relative !important; z-index: 9999999 !important; -webkit-font-smoothing: antialiased !important; -moz-osx-font-smoothing: grayscale !important; text-rendering: optimizeLegibility !important; }
#oel-chatbot-wrapper, #oel-chatbot-wrapper * { box-sizing: border-box !important; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important; letter-spacing: normal !important; text-transform: none !important; }
#oel-chatbot-wrapper p, #oel-chatbot-wrapper span, #oel-chatbot-wrapper h3, #oel-chatbot-wrapper strong, #oel-chatbot-wrapper a, #oel-chatbot-wrapper button, #oel-chatbot-wrapper input { margin: 0 !important; padding: 0 !important; line-height: normal !important; }
#oel-chatbot-wrapper .oel-launcher-wrap { position: fixed !important; bottom: 20px !important; left: 20px !important; z-index: 9999999 !important; }
#oel-chatbot-wrapper .oel-launcher-btn { display: flex !important; align-items: center !important; justify-content: center !important; background: transparent !important; border: none !important; padding: 0 !important; margin: 0 !important; cursor: pointer !important; outline: none !important; border-radius: 9999px !important; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1) !important; }
#oel-chatbot-wrapper .oel-launcher-btn:hover { transform: scale(1.08) !important; }
#oel-chatbot-wrapper .oel-launcher-btn:active { transform: scale(0.94) !important; }
#oel-chatbot-wrapper .oel-icon-closed { display: flex !important; animation: oelFloat 3.2s ease-in-out infinite !important; filter: drop-shadow(0 8px 18px rgba(7, 7, 88, 0.35)) !important; }
#oel-chatbot-wrapper .oel-bot-img { width: 90px !important; height: 90px !important; max-width: 90px !important; max-height: 90px !important; object-fit: contain !important; user-select: none !important; pointer-events: none !important; display: block !important; }
@keyframes oelFloat { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-8px) rotate(1.5deg); } }
#oel-chatbot-wrapper .oel-icon-open { display: none !important; width: 44px !important; height: 44px !important; border-radius: 50% !important; background: #070758 !important; align-items: center !important; justify-content: center !important; box-shadow: 0 6px 20px rgba(7, 7, 88, 0.35) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; transition: background 0.15s ease !important; }
#oel-chatbot-wrapper .oel-launcher-btn:hover .oel-icon-open { background: #224099 !important; }
#oel-chatbot-wrapper .oel-launcher-btn.is-active .oel-icon-closed { display: none !important; }
#oel-chatbot-wrapper .oel-launcher-btn.is-active .oel-icon-open { display: flex !important; }
#oel-chatbot-wrapper .oel-window { display: none !important; position: fixed !important; bottom: 82px !important; left: 20px !important; z-index: 9999999 !important; width: 360px !important; height: 490px !important; max-width: calc(100vw - 24px) !important; max-height: calc(100vh - 100px) !important; background: #ffffff !important; border-radius: 12px !important; box-shadow: 0 14px 44px rgba(0, 0, 0, 0.18) !important; border: 1px solid #e2e8f0 !important; flex-direction: column !important; overflow: hidden !important; }
#oel-chatbot-wrapper .oel-window.is-open { display: flex !important; animation: oelSlideUp 0.18s ease-out forwards !important; }
@keyframes oelSlideUp { from { opacity: 0; transform: translateY(10px) scale(0.96); } to { opacity: 1; transform: translateY(0) scale(1); } }
#oel-chatbot-wrapper .oel-header { background: #070758 !important; color: #ffffff !important; padding: 10px 14px !important; display: flex !important; align-items: center !important; justify-content: space-between !important; border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important; flex-shrink: 0 !important; user-select: none !important; }
#oel-chatbot-wrapper .oel-brand { display: flex !important; align-items: center !important; gap: 8px !important; }
#oel-chatbot-wrapper .oel-logo-box { width: 44px !important; height: 28px !important; border-radius: 5px !important; background: #ffffff !important; padding: 2px 4px !important; display: flex !important; align-items: center !important; justify-content: center !important; flex-shrink: 0 !important; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08) !important; }
#oel-chatbot-wrapper .oel-logo { width: 100% !important; height: 100% !important; object-fit: contain !important; }
#oel-chatbot-wrapper .oel-title { font-size: 13px !important; font-weight: 600 !important; color: #ffffff !important; margin: 0 !important; line-height: 1.25 !important; }
#oel-chatbot-wrapper .oel-sub { font-size: 10px !important; font-weight: 400 !important; color: rgba(255, 255, 255, 0.6) !important; margin: 2px 0 0 !important; line-height: 1 !important; }
#oel-chatbot-wrapper .oel-actions { display: flex !important; align-items: center !important; gap: 6px !important; }
#oel-chatbot-wrapper .oel-new-btn { display: flex !important; align-items: center !important; gap: 4px !important; font-size: 10.5px !important; font-weight: 500 !important; color: rgba(255, 255, 255, 0.85) !important; background: rgba(255, 255, 255, 0.1) !important; border: 1px solid rgba(255, 255, 255, 0.15) !important; padding: 2.5px 8px !important; border-radius: 4px !important; cursor: pointer !important; transition: all 0.15s ease !important; }
#oel-chatbot-wrapper .oel-new-btn:hover { color: #ffffff !important; background: rgba(255, 255, 255, 0.2) !important; }
#oel-chatbot-wrapper .oel-close-btn { background: transparent !important; border: none !important; color: rgba(255, 255, 255, 0.6) !important; padding: 4px !important; border-radius: 4px !important; cursor: pointer !important; display: flex !important; align-items: center !important; justify-content: center !important; transition: color 0.15s, background-color 0.15s !important; }
#oel-chatbot-wrapper .oel-close-btn:hover { color: #ffffff !important; background: rgba(255, 255, 255, 0.1) !important; }
#oel-chatbot-wrapper .oel-body { position: relative !important; flex: 1 !important; min-height: 0 !important; overflow-y: auto !important; padding: 12px !important; background: #f8fafc !important; display: flex !important; flex-direction: column !important; gap: 10px !important; scrollbar-width: thin !important; scrollbar-color: #cbd5e1 transparent !important; }
#oel-chatbot-wrapper .oel-body::-webkit-scrollbar { width: 5px !important; }
#oel-chatbot-wrapper .oel-body::-webkit-scrollbar-thumb { background: #cbd5e1 !important; border-radius: 4px !important; }
#oel-chatbot-wrapper .oel-row { display: flex !important; gap: 6px !important; width: 100% !important; flex-shrink: 0 !important; }
#oel-chatbot-wrapper .oel-row.user { justify-content: flex-end !important; }
#oel-chatbot-wrapper .oel-row.bot { justify-content: flex-start !important; align-items: flex-start !important; }
#oel-chatbot-wrapper .oel-bot-badge { width: 20px !important; height: 20px !important; border-radius: 4px !important; background: #070758 !important; color: #ffffff !important; display: flex !important; align-items: center !important; justify-content: center !important; flex-shrink: 0 !important; margin-top: 2px !important; }
#oel-chatbot-wrapper .oel-bot-badge.is-err { background: #d97706 !important; }
#oel-chatbot-wrapper .oel-bubble { max-width: 88% !important; padding: 8px 12px !important; font-size: 12px !important; line-height: 1.55 !important; word-break: break-word !important; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important; flex-shrink: 0 !important; }
#oel-chatbot-wrapper .oel-row.user .oel-bubble { background: #224099 !important; color: #ffffff !important; border-radius: 12px 12px 0px 12px !important; font-weight: 500 !important; box-shadow: 0 1px 3px rgba(34, 64, 153, 0.25) !important; }
#oel-chatbot-wrapper .oel-row.bot .oel-bubble { background: #ffffff !important; color: #1e293b !important; border: 1px solid #e2e8f0 !important; border-radius: 12px 12px 12px 0px !important; }
#oel-chatbot-wrapper .oel-row.bot .oel-bubble.is-error { background: #fffbeb !important; color: #78350f !important; border-color: #fde68a !important; }
#oel-chatbot-wrapper .oel-text { font-size: 12px !important; line-height: 1.55 !important; white-space: pre-wrap !important; word-break: break-word !important; color: inherit !important; }
#oel-chatbot-wrapper .oel-text strong { font-weight: 600 !important; }
#oel-chatbot-wrapper .oel-row.user .oel-text strong { color: #ffffff !important; }
#oel-chatbot-wrapper .oel-row.bot .oel-text strong { color: #0f172a !important; }
#oel-chatbot-wrapper .oel-bullet { color: #224099 !important; font-weight: 700 !important; margin-right: 4px !important; display: inline-block !important; }
#oel-chatbot-wrapper .oel-text a { display: inline-flex !important; align-items: center !important; gap: 2px !important; font-weight: 600 !important; text-decoration: underline !important; word-break: break-all !important; outline: none !important; }
#oel-chatbot-wrapper .oel-row.user .oel-text a { color: #ffffff !important; }
#oel-chatbot-wrapper .oel-row.user .oel-text a:hover { color: rgba(255, 255, 255, 0.85) !important; }
#oel-chatbot-wrapper .oel-row.bot .oel-text a { color: #224099 !important; }
#oel-chatbot-wrapper .oel-row.bot .oel-text a:hover { color: #172b68 !important; }
#oel-chatbot-wrapper .oel-ext-icon { width: 10px !important; height: 10px !important; margin-left: 2px !important; opacity: 0.75 !important; display: inline-block !important; vertical-align: middle !important; }
#oel-chatbot-wrapper .oel-time { display: block !important; font-size: 8.5px !important; margin: 4px 0 0 !important; text-align: right !important; line-height: 1 !important; }
#oel-chatbot-wrapper .oel-row.user .oel-time { color: rgba(255, 255, 255, 0.65) !important; }
#oel-chatbot-wrapper .oel-row.bot .oel-time { color: #94a3b8 !important; }
#oel-chatbot-wrapper .oel-retry-btn { display: inline-flex !important; align-items: center !important; gap: 4px !important; font-size: 11px !important; font-weight: 600 !important; color: #78350f !important; background: #fef3c7 !important; border: 1px solid #fcd34d !important; padding: 3px 8px !important; border-radius: 4px !important; margin-top: 6px !important; cursor: pointer !important; transition: all 0.15s ease !important; }
#oel-chatbot-wrapper .oel-retry-btn:hover { background: #fde68a !important; }
#oel-chatbot-wrapper .oel-retry-btn:disabled { opacity: 0.5 !important; cursor: not-allowed !important; pointer-events: none !important; }
#oel-chatbot-wrapper .oel-dots { display: inline-flex !important; align-items: center !important; gap: 4px !important; padding: 7px 12px !important; background: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 12px 12px 12px 0px !important; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important; }
#oel-chatbot-wrapper .oel-dot { width: 5px !important; height: 5px !important; border-radius: 50% !important; background: #94a3b8 !important; animation: oelBounce 1.4s infinite ease-in-out both !important; }
#oel-chatbot-wrapper .oel-dot:nth-child(1) { animation-delay: -0.32s !important; }
#oel-chatbot-wrapper .oel-dot:nth-child(2) { animation-delay: -0.16s !important; }
@keyframes oelBounce { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
#oel-chatbot-wrapper .oel-pills { display: grid !important; grid-template-columns: repeat(2, 1fr) !important; gap: 6px !important; padding-top: 6px !important; width: 100% !important; }
#oel-chatbot-wrapper .oel-pill-btn { font-size: 11px !important; font-weight: 500 !important; color: #475569 !important; background: #ffffff !important; border: 1px solid #cbd5e1 !important; padding: 6px 8px !important; border-radius: 16px !important; cursor: pointer !important; transition: all 0.15s ease !important; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important; text-align: center !important; line-height: 1.25 !important; display: flex !important; align-items: center !important; justify-content: center !important; min-height: 32px !important; width: 100% !important; }
#oel-chatbot-wrapper .oel-pill-btn:hover { background: #224099 !important; color: #ffffff !important; border-color: #224099 !important; }
#oel-chatbot-wrapper .oel-footer { padding: 8px 10px 6px !important; background: #ffffff !important; border-top: 1px solid #e2e8f0 !important; flex-shrink: 0 !important; width: 100% !important; }
#oel-chatbot-wrapper .oel-form { display: flex !important; flex-direction: row !important; align-items: center !important; gap: 6px !important; background: #f8fafc !important; border: 1px solid #cbd5e1 !important; border-radius: 8px !important; padding: 4px 6px 4px 10px !important; width: 100% !important; margin: 0 !important; box-sizing: border-box !important; transition: all 0.15s ease !important; min-height: 38px !important; }
#oel-chatbot-wrapper .oel-form:focus-within { background: #ffffff !important; border-color: #224099 !important; box-shadow: 0 0 0 2px rgba(34, 64, 153, 0.12) !important; }
#oel-chatbot-wrapper .oel-input { flex: 1 1 auto !important; width: 100% !important; min-width: 0 !important; height: 30px !important; border: none !important; background: transparent !important; font-size: 13px !important; color: #1e293b !important; outline: none !important; padding: 0 !important; margin: 0 !important; line-height: 30px !important; box-shadow: none !important; -webkit-appearance: none !important; appearance: none !important; }
#oel-chatbot-wrapper .oel-input::placeholder { color: #94a3b8 !important; opacity: 1 !important; font-size: 12.5px !important; }
#oel-chatbot-wrapper .oel-send-btn { flex: 0 0 28px !important; width: 28px !important; height: 28px !important; min-width: 28px !important; min-height: 28px !important; max-width: 28px !important; max-height: 28px !important; border-radius: 6px !important; background: #224099 !important; border: none !important; padding: 0 !important; margin: 0 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; transition: background 0.15s ease, opacity 0.15s ease !important; color: #ffffff !important; outline: none !important; }
#oel-chatbot-wrapper .oel-send-btn svg { width: 13px !important; height: 13px !important; display: block !important; margin: auto !important; pointer-events: none !important; }
#oel-chatbot-wrapper .oel-send-btn:hover:not(:disabled) { background: #172b68 !important; }
#oel-chatbot-wrapper .oel-send-btn:active:not(:disabled) { background: #0f1c48 !important; }
#oel-chatbot-wrapper .oel-send-btn:disabled { opacity: 0.35 !important; cursor: not-allowed !important; }
#oel-chatbot-wrapper .oel-powered { text-align: center !important; padding-top: 6px !important; padding-bottom: 2px !important; font-size: 11px !important; color: #94a3b8 !important; font-weight: 500 !important; letter-spacing: 0.02em !important; user-select: none !important; pointer-events: none !important; }
#oel-chatbot-wrapper .oel-powered span { font-weight: 600 !important; color: #224099 !important; }
#oel-chatbot-wrapper .oel-sr-only { position: absolute !important; width: 1px !important; height: 1px !important; padding: 0 !important; margin: -1px !important; overflow: hidden !important; clip: rect(0, 0, 0, 0) !important; white-space: nowrap !important; border: 0 !important; }
@media (max-width: 480px) {
  #oel-chatbot-wrapper .oel-launcher-wrap { bottom: 15px !important; left: 15px !important; }
  #oel-chatbot-wrapper .oel-bot-img { width: 76px !important; height: 76px !important; }
  #oel-chatbot-wrapper .oel-window { bottom: 76px !important; left: 12px !important; width: calc(100vw - 24px) !important; height: calc(100vh - 100px) !important; max-height: 480px !important; }
}
@media (max-height: 550px) { #oel-chatbot-wrapper .oel-window { height: calc(100vh - 90px) !important; } }
@media (prefers-reduced-motion: reduce) { #oel-chatbot-wrapper .oel-icon-closed, #oel-chatbot-wrapper .oel-window.is-open, #oel-chatbot-wrapper .oel-dot { animation: none !important; transition: none !important; } }
</style>
<div id="oel-chatbot-wrapper">
  <div class="oel-launcher-wrap">
    <button type="button" id="oelChatLauncher" class="oel-launcher-btn" aria-label="Open Overseas Education Lane AI Assistant" aria-expanded="false" aria-controls="oelChatWindow" aria-haspopup="dialog">
      <span class="oel-icon-closed">
        <img src="{{ $chatbot_robot }}" alt="OEL AI Assistant" class="oel-bot-img" width="90" height="90" loading="eager" fetchpriority="high" decoding="async">
      </span>
      <span class="oel-icon-open">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </span>
    </button>
  </div>
  <div id="oelChatWindow" class="oel-window" role="dialog" aria-modal="false" aria-label="Overseas Education Lane AI Assistant" aria-describedby="oelChatDesc">
    <p id="oelChatDesc" class="oel-sr-only">Interactive Overseas Education Lane support assistant. Press Escape to close.</p>
    <div class="oel-header">
      <div class="oel-brand">
        <div class="oel-logo-box">
          <img src="{{ $chatbot_logo }}" alt="OEL Logo" class="oel-logo">
        </div>
        <div>
          <h3 class="oel-title">OEL Assistant</h3>
          <p class="oel-sub">AI Education Advisor</p>
        </div>
      </div>
      <div class="oel-actions">
        <button type="button" id="oelNewChatBtn" class="oel-new-btn" title="Start a new chat conversation" aria-label="Start a new chat conversation" style="display:none;">
          <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>New Chat</span>
        </button>
        <button type="button" id="oelCloseBtn" class="oel-close-btn" title="Close chat window" aria-label="Close chat window">
          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </div>
    <div id="oelMessages" class="oel-body" role="log" aria-live="polite" aria-relevant="additions text"></div>
    <div class="oel-footer">
      <form id="oelChatForm" class="oel-form" onsubmit="return false;">
        <label for="oelChatInput" class="oel-sr-only">Type your message to OEL Assistant</label>
        <input id="oelChatInput" type="text" class="oel-input" placeholder="Ask anything about studying abroad..." maxlength="1000" autocomplete="off" aria-label="Type your message to OEL Assistant" aria-required="true">
        <button type="submit" id="oelSendBtn" class="oel-send-btn" disabled aria-label="Send message">
          <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
        </button>
      </form>
      <div class="oel-powered" aria-hidden="true">
        Powered by <span>SkyLabs</span>
      </div>
    </div>
  </div>
</div>
<script>
(function() {
  "use strict";
  var API_URL = @json($chatbot_api_url);
  var QUICK_QUESTIONS = [
    "Study Abroad Guidance",
    "Top Study Destinations",
    "Korean Language Classes",
    "Scholarships & Loans"
  ];
  function getWelcomeMessage() {
    return [{ id: "welcome", sender: "bot", text: "Hello! Welcome to Overseas Education Lane. How can I assist you with your study abroad journey today?", time: getTime() }];
  }
  var isOpen = false;
  var isTyping = false;
  var sessionId = null;
  var activeAbortController = null;
  var activeTimeoutId = null;
  var currentRequestId = 0;
  var messages = getWelcomeMessage();
  var launcher = document.getElementById("oelChatLauncher");
  var win = document.getElementById("oelChatWindow");
  var body = document.getElementById("oelMessages");
  var form = document.getElementById("oelChatForm");
  var input = document.getElementById("oelChatInput");
  var sendBtn = document.getElementById("oelSendBtn");
  var newBtn = document.getElementById("oelNewChatBtn");
  var closeBtn = document.getElementById("oelCloseBtn");
  var wrap = document.getElementById("oel-chatbot-wrapper");
  function getTime() {
    return new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
  }
  function esc(s) {
    if (typeof s !== "string") return "";
    return s.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#39;");
  }
  function cleanPunctuation(raw, isUrl) {
    if (typeof raw !== "string") return null;
    var str = raw.trim();
    var leading = "";
    var trailing = "";
    while (str.length > 0 && /[([{"'<]/.test(str[0])) { leading += str[0]; str = str.slice(1); }
    while (str.length > 0) {
      var last = str.slice(-1);
      if (/[.,;:!?"'>\]}]/.test(last)) { trailing = last + trailing; str = str.slice(0, -1); }
      else if (last === ")") {
        if (isUrl) {
          var openCount = (str.match(/\(/g) || []).length;
          var closeCount = (str.match(/\)/g) || []).length;
          if (closeCount > openCount) { trailing = last + trailing; str = str.slice(0, -1); continue; }
          break;
        } else { trailing = last + trailing; str = str.slice(0, -1); }
      } else { break; }
    }
    return { leading: leading, core: str, trailing: trailing };
  }
  function parseSafeUrl(raw) {
    var parts = cleanPunctuation(raw, true);
    if (!parts || !parts.core) return null;
    try {
      var parsed = new URL(parts.core);
      if (parsed.protocol !== "https:" && parsed.protocol !== "http:") return null;
      if (!parsed.hostname || (!parsed.hostname.includes(".") && parsed.hostname !== "localhost")) return null;
      return { leading: parts.leading, cleanUrl: parts.core, safeHref: parsed.href, trailing: parts.trailing };
    } catch (e) { return null; }
  }
  function parseSafeEmail(raw) {
    var parts = cleanPunctuation(raw, false);
    if (!parts || !parts.core) return null;
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/;
    if (emailRegex.test(parts.core) && !parts.core.includes("..")) {
      return { leading: parts.leading, email: parts.core, trailing: parts.trailing };
    }
    return null;
  }
  function formatMsg(text, isUser) {
    if (typeof text !== "string") return "";
    var s = esc(text);
    s = s.replace(/\[([^\]]+)\]\((https?:\/\/[^\s<>"']+)\)/g, function(_, rawLabel, rawUrl) {
      var safe = parseSafeUrl(rawUrl);
      var safeLabel = rawLabel.trim();
      if (!safe) return safeLabel + ' (' + esc(rawUrl) + ')';
      return '<a href="' + esc(safe.safeHref) + '" target="_blank" rel="noopener noreferrer nofollow" title="External link">' + safeLabel + '<svg class="oel-ext-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg></a>';
    });
    s = s.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
    s = s.replace(/(?:^|\n)[-*]\s+(.+)/g, '\n<span class="oel-bullet" aria-hidden="true">•</span> $1');
    s = s.replace(/(^|[^">])(https?:\/\/[^\s<>"']+)/g, function(match, prefix, rawUrl) {
      var res = parseSafeUrl(rawUrl);
      if (!res) return prefix + esc(rawUrl);
      return prefix + esc(res.leading) + '<a href="' + esc(res.safeHref) + '" target="_blank" rel="noopener noreferrer nofollow" title="' + esc(res.safeHref) + '">' + esc(res.cleanUrl) + '<svg class="oel-ext-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg></a>' + esc(res.trailing);
    });
    s = s.replace(/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/g, function(rawEmail) {
      var res = parseSafeEmail(rawEmail);
      if (!res) return esc(rawEmail);
      return esc(res.leading) + '<a href="mailto:' + esc(res.email) + '">' + esc(res.email) + '</a>' + esc(res.trailing);
    });
    return s;
  }
  function render() {
    if (!body) return;
    var html = "";
    for (var i = 0; i < messages.length; i++) {
      var m = messages[i];
      var isUser = m.sender === "user";
      html += '<div class="oel-row ' + (isUser ? 'user' : 'bot') + '" data-msg-id="' + esc(m.id) + '">';
      if (!isUser) {
        var avClass = m.isError ? "oel-bot-badge is-err" : "oel-bot-badge";
        var avIcon = m.isError
          ? '<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>'
          : '<svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path></svg>';
        html += '<div class="' + avClass + '" aria-hidden="true">' + avIcon + '</div>';
      }
      html += '<div class="oel-bubble' + (m.isError ? ' is-error' : '') + '">';
      html += '<p class="oel-text">' + formatMsg(m.text, isUser) + '</p>';
      if (m.isError && m.retry) {
        html += '<button type="button" class="oel-retry-btn" data-retry="' + esc(m.retry) + '" ' + (isTyping ? 'disabled' : '') + '><svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path></svg> Retry</button>';
      }
      html += '<span class="oel-time">' + esc(m.time) + '</span>';
      html += '</div></div>';
    }
    if (isTyping) {
      html += '<div class="oel-row bot" id="oelTypingRow"><div class="oel-bot-badge" aria-hidden="true"><svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"></path><rect width="16" height="12" x="4" y="8" rx="2"></rect><path d="M2 14h2"></path><path d="M20 14h2"></path><path d="M15 13v2"></path><path d="M9 13v2"></path></svg></div><div class="oel-dots" role="status" aria-live="polite" aria-label="OEL Assistant is typing a reply"><span class="oel-dot"></span><span class="oel-dot"></span><span class="oel-dot"></span></div></div>';
    }
    if (messages.length <= 2 && !isTyping) {
      html += '<div class="oel-pills" role="group" aria-label="Suggested quick questions">';
      for (var q = 0; q < QUICK_QUESTIONS.length; q++) {
        html += '<button type="button" class="oel-pill-btn" data-q="' + esc(QUICK_QUESTIONS[q]) + '">' + esc(QUICK_QUESTIONS[q]) + '</button>';
      }
      html += '</div>';
    }
    body.innerHTML = html;
    if (newBtn) newBtn.style.display = messages.length > 1 ? "flex" : "none";
  }
  function scrollToMsg(msgId) {
    if (!body) return;
    if (msgId) {
      var el = body.querySelector('[data-msg-id="' + msgId + '"]');
      if (el) {
        setTimeout(function() {
          body.scrollTo({ top: Math.max(0, el.offsetTop - 10), behavior: "smooth" });
          if (input) input.focus();
        }, 60);
        return;
      }
    }
    setTimeout(function() {
      if (body) body.scrollTop = body.scrollHeight;
      if (input) input.focus();
    }, 60);
  }
  function cancelInFlightRequest() {
    if (activeTimeoutId) { clearTimeout(activeTimeoutId); activeTimeoutId = null; }
    if (activeAbortController) {
      try { activeAbortController.abort(); } catch (e) {}
      activeAbortController = null;
    }
  }
  function send(txt) {
    var val = (txt || (input ? input.value : "")).trim();
    if (!val || isTyping) return;
    if (txt) {
      messages = messages.filter(function(m) { return !(m.isError && m.retry === txt); });
    }
    var userMsgId = "u_" + Date.now();
    messages.push({ id: userMsgId, sender: "user", text: val, time: getTime() });
    if (input) { input.value = ""; input.focus(); }
    if (sendBtn) sendBtn.disabled = true;
    isTyping = true;
    render();
    scrollToMsg(userMsgId);
    cancelInFlightRequest();
    var thisRequestId = ++currentRequestId;
    var controller = null;
    if (typeof AbortController !== "undefined") {
      controller = new AbortController();
      activeAbortController = controller;
    }
    activeTimeoutId = setTimeout(function() {
      if (thisRequestId !== currentRequestId) return;
      if (controller) { try { controller.abort(); } catch (e) {} }
      handleErr("Connection timed out. The server took too long to reply.", val, thisRequestId);
    }, 30000);
    var payload = { message: val };
    if (sessionId) { payload.session_id = sessionId; }
    var fetchOptions = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    };
    if (controller) { fetchOptions.signal = controller.signal; }
    fetch(API_URL, fetchOptions)
    .then(function(res) {
      if (!res.ok) {
        if (res.status === 429) throw new Error("RATE_LIMIT");
        if (res.status >= 500) throw new Error("SERVER_UNAVAILABLE");
        throw new Error("HTTP_" + res.status);
      }
      return res.json();
    })
    .then(function(data) {
      cancelInFlightRequest();
      if (thisRequestId !== currentRequestId) return;
      if (data && typeof data === "object" && data.session_id) { sessionId = data.session_id; }
      var rep = "";
      if (data && typeof data === "object") {
        rep = data.reply || data.response || data.message || data.text || "";
        if (typeof rep === "string") { rep = rep.trim(); }
      }
      if (!rep) { throw new Error("INVALID_RESPONSE"); }
      var botMsgId = "b_" + Date.now();
      messages.push({ id: botMsgId, sender: "bot", text: rep, time: getTime() });
      finishRequest(botMsgId, thisRequestId);
    })
    .catch(function(err) {
      cancelInFlightRequest();
      if (thisRequestId !== currentRequestId) return;
      var msg = "Unable to connect to the server. Please try again.";
      if (!navigator.onLine) {
        msg = "You appear to be offline. Please check your internet connection.";
      } else if (err && (err.name === "AbortError" || err.message === "Connection timed out.")) {
        msg = "Connection timed out. The server took too long to reply.";
      } else if (err && err.message === "RATE_LIMIT") {
        msg = "Too many requests. Please wait a moment before sending another message.";
      } else if (err && err.message === "SERVER_UNAVAILABLE") {
        msg = "The assistant service is temporarily unavailable. Please try again shortly.";
      } else if (err && err.message === "INVALID_RESPONSE") {
        msg = "Received an invalid response format from the server. Please try again.";
      } else if (err && err.message && err.message.indexOf("HTTP_") === 0) {
        msg = "Service returned an error (" + err.message.replace("HTTP_", "status ") + "). Please try again.";
      }
      handleErr(msg, val, thisRequestId);
    });
  }
  function finishRequest(targetMsgId, reqId) {
    if (reqId && reqId !== currentRequestId) return;
    isTyping = false;
    render();
    if (sendBtn && input) sendBtn.disabled = !input.value.trim();
    scrollToMsg(targetMsgId);
  }
  function handleErr(msg, retry, reqId) {
    if (reqId && reqId !== currentRequestId) return;
    var errId = "e_" + Date.now();
    messages.push({ id: errId, sender: "bot", text: msg, time: getTime(), isError: true, retry: retry });
    finishRequest(errId, reqId);
  }
  function toggle(open, shouldFocusLauncher) {
    isOpen = open;
    if (isOpen) {
      win.classList.add("is-open");
      launcher.classList.add("is-active");
      launcher.setAttribute("aria-expanded", "true");
      render();
      if (body) body.scrollTop = 0;
      setTimeout(function() { if (input) input.focus(); }, 50);
    } else {
      win.classList.remove("is-open");
      launcher.classList.remove("is-active");
      launcher.setAttribute("aria-expanded", "false");
      if (shouldFocusLauncher && launcher) { launcher.focus(); }
    }
  }
  if (body) {
    body.addEventListener("click", function(e) {
      var pill = e.target.closest(".oel-pill-btn");
      if (pill) {
        e.preventDefault();
        e.stopPropagation();
        send(pill.getAttribute("data-q"));
        return;
      }
      var retry = e.target.closest(".oel-retry-btn");
      if (retry) {
        e.preventDefault();
        e.stopPropagation();
        if (!isTyping) { send(retry.getAttribute("data-retry")); }
        return;
      }
    });
  }
  if (launcher) { launcher.onclick = function(e) { e.stopPropagation(); toggle(!isOpen, true); }; }
  if (closeBtn) { closeBtn.onclick = function(e) { e.stopPropagation(); toggle(false, true); }; }
  if (newBtn) {
    newBtn.onclick = function(e) {
      e.stopPropagation();
      cancelInFlightRequest();
      currentRequestId++;
      sessionId = null;
      isTyping = false;
      messages = getWelcomeMessage();
      if (input) { input.value = ""; input.focus(); }
      if (sendBtn) sendBtn.disabled = true;
      render();
      if (body) body.scrollTop = 0;
    };
  }
  if (form) { form.onsubmit = function(e) { e.preventDefault(); send(); }; }
  if (input) {
    input.oninput = function() {
      if (sendBtn) sendBtn.disabled = !this.value.trim() || isTyping;
    };
  }
  document.addEventListener("click", function(e) {
    if (isOpen && wrap && !wrap.contains(e.target)) toggle(false, true);
  });
  document.addEventListener("keydown", function(e) {
    if (e.key === "Escape" && isOpen) toggle(false, true);
  });
  toggle(false, false);
})();
</script>