@extends('layouts.app')

@section('header')

@auth
<form action="{{ route('global.search') }}" method="GET" class="flex gap-2 justify-center py-6">
    <input type="text" name="search" placeholder="Search ..." value="{{ request('search') }}"
        class="bg-transparent text-gray-100 border border-gray-600 px-4 py-2 rounded-lg w-full max-w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
        Search
    </button>
</form>
@endauth
@endsection

@section('content')
<div class="min-h-screen bg-transparent flex items-center justify-center py-3 mb-10 scroll-m-0">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-indigo-600 px-6 py-4 text-black">
            <h2 class="text-lg font-semibold text-center py-3 text-white">ChatBot</h2>

            <!-- Chat Box -->
            <div id="chat-box" class="border rounded-lg p-4 h-96 overflow-y-auto bg-gray-50 mb-4 space-y-2">
            </div>

            <!-- Input -->
            <div class="flex gap-2">
                <input type="text" id="chat-input" placeholder="Type a message..."
                    class="flex-1 border border-black rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                <button id="send-btn"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    const chatBox = document.getElementById('chat-box');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');

    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function addMessage(role, text) {
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('flex', 'mb-2');

        if (role === 'user') {
            msgDiv.classList.add('justify-end');
            msgDiv.innerHTML = `
                <div class="bg-indigo-600 text-white px-4 py-2 rounded-xl rounded-tr-none max-w-xs shadow">
                    <b>You:</b> ${text}
                </div>
            `;
        } else {
            msgDiv.classList.add('justify-start');
            msgDiv.innerHTML = `
                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl rounded-tl-none max-w-xs shadow">
                    <b>ShopEaseAI:</b> ${text}
                </div>
            `;
        }

        chatBox.appendChild(msgDiv);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function addTyping() {
        const typing = document.createElement('div');
        typing.id = 'typing';
        typing.className = 'text-gray-500 text-sm';
        typing.innerText = 'ShopEaseAI is typing...';
        chatBox.appendChild(typing);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function removeTyping() {
        const typing = document.getElementById('typing');
        if (typing) typing.remove();
    }

    sendBtn.addEventListener('click', () => {
        const message = chatInput.value.trim();
        if (!message) return;

        addMessage('user', message);
        chatInput.value = '';
        chatInput.disabled = true;
        sendBtn.disabled = true;

        addTyping();

        axios.post("{{ route('chat.send') }}", {
                message
            })
            .then(res => {
                removeTyping();
                addMessage('assistant', res.data.reply ?? 'No response from AI.');
            })
            .catch(err => {
                removeTyping();
                console.error('AXIOS ERROR:', err.response ?? err);

                const msg =
                    err.response?.data?.reply ||
                    err.response?.data?.message ||
                    'Server error. Check logs.';

                addMessage('assistant', msg);
            });
    });

    chatInput.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') sendBtn.click();
    });
</script>
@endsection