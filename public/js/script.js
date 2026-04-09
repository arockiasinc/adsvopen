document.documentElement.classList.add("has-js");

const mobileMenuQuery = window.matchMedia("(max-width: 720px)");
const mobileMenus = Array.from(document.querySelectorAll("[data-mobile-menu]"));

mobileMenus.forEach((menu) => {
  const toggle = menu.querySelector("[data-mobile-menu-toggle]");
  const panel = menu.querySelector("[data-mobile-menu-panel]");
  const closeTargets = Array.from(
    menu.querySelectorAll(".site-header-link, .site-auth-link, .site-register-link"),
  );

  if (!toggle || !panel) {
    return;
  }

  const setMenuState = (isOpen) => {
    menu.dataset.mobileMenuOpen = String(isOpen);
    toggle.setAttribute("aria-expanded", String(isOpen));

    if (mobileMenuQuery.matches) {
      panel.hidden = !isOpen;
      return;
    }

    panel.hidden = false;
  };

  setMenuState(false);

  toggle.addEventListener("click", () => {
    setMenuState(menu.dataset.mobileMenuOpen !== "true");
  });

  closeTargets.forEach((target) => {
    target.addEventListener("click", () => {
      if (mobileMenuQuery.matches) {
        setMenuState(false);
      }
    });
  });

  document.addEventListener("click", (event) => {
    if (!mobileMenuQuery.matches || menu.dataset.mobileMenuOpen !== "true") {
      return;
    }

    if (!menu.contains(event.target)) {
      setMenuState(false);
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key !== "Escape" || menu.dataset.mobileMenuOpen !== "true") {
      return;
    }

    setMenuState(false);
    toggle.focus();
  });

  mobileMenuQuery.addEventListener("change", () => {
    setMenuState(false);
  });
});

const carousel = document.querySelector("[data-carousel]");

if (carousel) {
  const slides = Array.from(carousel.querySelectorAll("[data-slide]"));
  const dots = Array.from(carousel.querySelectorAll("[data-dot]"));
  const controls = Array.from(carousel.querySelectorAll("[data-direction]"));
  const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const activeSlideClasses = ["translate-y-0", "opacity-100", "visible", "pointer-events-auto"];
  const inactiveSlideClasses = ["translate-y-2", "opacity-0", "invisible", "pointer-events-none"];
  const activeDotClasses = ["bg-accent", "scale-110"];
  const inactiveDotClasses = ["bg-ink/20"];
  let activeIndex = 0;
  let autoAdvanceId = null;

  const renderSlide = (nextIndex) => {
    slides.forEach((slide, index) => {
      const isActive = index === nextIndex;
      slide.classList.remove(...(isActive ? inactiveSlideClasses : activeSlideClasses));
      slide.classList.add(...(isActive ? activeSlideClasses : inactiveSlideClasses));
    });

    dots.forEach((dot, index) => {
      const isActive = index === nextIndex;
      dot.classList.remove(...(isActive ? inactiveDotClasses : activeDotClasses));
      dot.classList.add(...(isActive ? activeDotClasses : inactiveDotClasses));
      dot.setAttribute("aria-pressed", String(isActive));
    });

    activeIndex = nextIndex;
  };

  const stepSlide = (direction) => {
    const nextIndex = (activeIndex + direction + slides.length) % slides.length;
    renderSlide(nextIndex);
  };

  const stopAutoAdvance = () => {
    if (autoAdvanceId) {
      window.clearInterval(autoAdvanceId);
      autoAdvanceId = null;
    }
  };

  const startAutoAdvance = () => {
    if (prefersReducedMotion || slides.length < 2) {
      return;
    }

    stopAutoAdvance();
    autoAdvanceId = window.setInterval(() => {
      stepSlide(1);
    }, 4200);
  };

  controls.forEach((control) => {
    control.addEventListener("click", () => {
      stepSlide(control.dataset.direction === "prev" ? -1 : 1);
      startAutoAdvance();
    });
  });

  dots.forEach((dot) => {
    dot.addEventListener("click", () => {
      renderSlide(Number(dot.dataset.dot));
      startAutoAdvance();
    });
  });

  carousel.addEventListener("mouseenter", stopAutoAdvance);
  carousel.addEventListener("mouseleave", startAutoAdvance);
  carousel.addEventListener("focusin", stopAutoAdvance);
  carousel.addEventListener("focusout", (event) => {
    if (!carousel.contains(event.relatedTarget)) {
      startAutoAdvance();
    }
  });
  carousel.addEventListener("keydown", (event) => {
    if (event.key === "ArrowLeft") {
      event.preventDefault();
      stepSlide(-1);
      startAutoAdvance();
    }

    if (event.key === "ArrowRight") {
      event.preventDefault();
      stepSlide(1);
      startAutoAdvance();
    }
  });

  renderSlide(activeIndex);
  startAutoAdvance();
}

const faqItems = Array.from(document.querySelectorAll("[data-faq-item]"));

faqItems.forEach((item) => {
  const trigger = item.querySelector("[data-faq-trigger]");
  const panel = item.querySelector("[data-faq-panel]");
  const symbol = item.querySelector("[data-faq-symbol]");

  if (!trigger || !panel) {
    return;
  }

  const renderFaqState = (isExpanded) => {
    trigger.setAttribute("aria-expanded", String(isExpanded));
    panel.hidden = !isExpanded;

    if (symbol) {
      symbol.textContent = isExpanded ? "\u2212" : "+";
    }
  };

  renderFaqState(trigger.getAttribute("aria-expanded") === "true");

  trigger.addEventListener("click", () => {
    const isExpanded = trigger.getAttribute("aria-expanded") === "true";
    renderFaqState(!isExpanded);
  });
});
