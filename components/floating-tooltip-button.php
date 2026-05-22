<style>
  .type--C {
    --line_color: #F78D37;
    --back_color: black;
  }

  .button {
    position: fixed;
    right: -170px;
    top: 55%;
    z-index: 99;
    width: 180px;
    height: 36px;
    text-decoration: none;
    transform: rotate(-90deg);
    transform-origin: right top;
    font-size: 14px;
    font-weight: bold;
    color: #F78D37;
    letter-spacing: 2px;
    transition: right 0.4s ease;
  }

  .button.visible {
    right: 65px;
    top: 55%;
  }

  @media (max-width: 992px) {
    .button {
      width: 150px;
      height: 34px;
      font-size: 12px;
      transform: rotate(-90deg);
      right: -140px;
      top: 72%;
    }

    .button.visible {
      right: 56px;
      top: 72%;
    }

    .button__line {
      width: 42px;
    }

    .button::before {
      left: 42px;
      width: calc(100% - 42px * 2 - 12px);
    }

    .button::after {
      right: 42px;
    }

    .button__text::before {
      right: 42px;
      width: calc(100% - 42px * 2 - 12px);
    }

    .button__text::after {
      left: 42px;
    }

    .eq-circle {
      width: 48px;
      height: 48px;
      right: 10px;
      top: 88%;
      transform: translateY(-50%);
    }

    .eq-circle:hover {
      transform: translateY(-50%) scale(1.08);
    }
  }

  @media (max-width: 1300px) {
    .button {
      display: none;
    }

    .eq-circle {
      width: 52px;
      height: 52px;
      right: 12px;
      bottom: 24px;
      top: auto;
      transform: none;
    }

    .eq-circle:hover {
      transform: scale(1.08);
    }
  }

  .button__text {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
  }

  .button::before,
  .button::after,
  .button__text::before,
  .button__text::after {
    content: "";
    position: absolute;
    height: 3px;
    border-radius: 2px;
    background: var(--line_color);
    transition: all 0.5s ease;
  }

  .button::before {
    top: 0;
    left: 54px;
    width: calc(100% - 56px * 2 - 16px);
  }

  .button::after {
    top: 0;
    right: 54px;
    width: 8px;
  }

  .button__text::before {
    bottom: 0;
    right: 54px;
    width: calc(100% - 56px * 2 - 16px);
  }

  .button__text::after {
    bottom: 0;
    left: 54px;
    width: 8px;
  }

  .button__line {
    position: absolute;
    top: 0;
    width: 56px;
    height: 100%;
    overflow: hidden;
  }

  .button__line::before {
    content: "";
    position: absolute;
    top: 0;
    width: 150%;
    height: 100%;
    box-sizing: border-box;
    border-radius: 300px;
    border: solid 3px var(--line_color);
  }

  .button__line:nth-child(1),
  .button__line:nth-child(1)::before {
    left: 0;
  }

  .button__line:nth-child(2),
  .button__line:nth-child(2)::before {
    right: 0;
  }

  .button:hover {
    letter-spacing: 4px;
  }

  .button:hover::before,
  .button:hover .button__text::before {
    width: 8px;
  }

  .button:hover::after,
  .button:hover .button__text::after {
    width: calc(100% - 56px * 2 - 16px);
  }

  .button:hover .button__drow1 {
    animation: drow1 ease-in 0.06s forwards;
  }

  .button:hover .button__drow1::before {
    animation: drow2 linear 0.08s 0.06s forwards;
  }

  .button:hover .button__drow1::after {
    animation: drow3 linear 0.03s 0.14s forwards;
  }

  .button:hover .button__drow2 {
    animation: drow4 linear 0.06s 0.2s forwards;
  }

  .button:hover .button__drow2::before {
    animation: drow3 linear 0.03s 0.26s forwards;
  }

  .button:hover .button__drow2::after {
    animation: drow5 linear 0.06s 0.32s forwards;
  }

  @keyframes drow1 {
    0% {
      height: 0;
    }

    100% {
      height: 100px;
    }
  }

  @keyframes drow2 {
    0% {
      width: 0;
      opacity: 0;
    }

    10% {
      opacity: 0;
    }

    11% {
      opacity: 1;
    }

    100% {
      width: 120px;
    }
  }

  @keyframes drow3 {
    0% {
      width: 0;
    }

    100% {
      width: 80px;
    }
  }

  @keyframes drow4 {
    0% {
      height: 0;
    }

    100% {
      height: 120px;
    }
  }

  @keyframes drow5 {
    0% {
      width: 0;
    }

    100% {
      width: 124px;
    }
  }

  .eq-circle {
    position: fixed;
    right: 14px;
    top: 95%;
    transform: translateY(-54px);
    z-index: 100;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #F78D37;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(247, 141, 55, 0.45);
    transition: transform 0.25s ease;
  }

  .eq-circle:hover {
    transform: translateY(-54px) scale(1.1);
  }
</style>

<div class="eq-circle" id="enquireCircle">
  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff"
    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
  </svg>
</div>

<a href="#" class="button type--C" id="enquireBtn" onclick="openApplyModal(); return false;">
  <div class="button__line"></div>
  <div class="button__line"></div>
  <span class="button__text">Enquire Now!</span>
  <div class="button__drow1"></div>
  <div class="button__drow2"></div>
</a>

<script>
  const enquireBtn = document.getElementById('enquireBtn');
  const enquireCircle = document.getElementById('enquireCircle');

  let hoverCircle = false;
  let hoverBtn = false;
  let timer;

  function showBtn() {
    clearTimeout(timer);
    enquireBtn.classList.add('visible');
  }

  function hideBtn() {
    clearTimeout(timer);
    timer = setTimeout(() => {
      if (!hoverCircle && !hoverBtn) {
        enquireBtn.classList.remove('visible');
      }
    }, 200);
  }

  // Desktop hover (500px se upar)
  enquireCircle.addEventListener('mouseenter', () => {
    hoverCircle = true;
    showBtn();
  });
  enquireCircle.addEventListener('mouseleave', () => {
    hoverCircle = false;
    hideBtn();
  });
  enquireBtn.addEventListener('mouseenter', () => {
    hoverBtn = true;
    showBtn();
  });
  enquireBtn.addEventListener('mouseleave', () => {
    hoverBtn = false;
    hideBtn();
  });

  // Circle click — 500px se niche seedha modal, upar bhi click kare toh modal
  enquireCircle.addEventListener('click', () => {
    if (typeof openApplyModal === 'function') openApplyModal();
  });
</script>

<?php include __DIR__ . '/Modals.php'; ?>