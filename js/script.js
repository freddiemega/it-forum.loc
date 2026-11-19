setTimeout(() => {
    const flashMessage = document.querySelector('.flash-message'); 
    if (flashMessage) {
        // 1. Делаем элемент полностью прозрачным (запустится CSS плавность)
        flashMessage.style.opacity = '0'; 
        
        // 2. Ждем 500 миллисекунд (0.5 сек), пока идет анимация, и удаляем из DOM
        setTimeout(() => {
            flashMessage.remove(); 
        }, 500); 
    }
}, 4000);
