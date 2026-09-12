/**
 * S54 Coffee - Luxury Collection Filter & Sort Engine
 * High-performance, zero-dependency, ultra-smooth interactive filtering.
 */
(function () {
  'use strict';

  function initS54Filter() {
    const root = document.querySelector('[data-collection-template]');
    if (!root) return;

    // Elements
    const body = document.body;
    const openDrawerBtns = document.querySelectorAll('[data-open-filters-button]');
    const closeDrawerBtns = document.querySelectorAll('[data-close-filters-button]');
    const drawerBg = document.querySelector('[data-close-drawer-button]');
    const clearFilterBtns = document.querySelectorAll('[data-clear-filters-button]');
    const countSpans = document.querySelectorAll('[data-collection-template-product-count]');
    const activeFilterCountSpan = document.querySelector('[data-active-filters-count]');
    const noResultsEl = document.querySelector('[data-collection-no-results]');
    const sortSelect = document.querySelector('#faceted-nav-sort');
    const topFilterBtns = document.querySelectorAll('[data-top-filter]');
    const drawerFilterBtns = document.querySelectorAll('[data-filter-group][data-filter-value]');
    const accordionTitles = document.querySelectorAll('.c-collection-template__faceted-nav__drawer [data-facet-title]');
    const productsContainer = document.querySelector('[data-collection-template-products]');

    if (!productsContainer) return;

    // Get all product cards
    const cards = Array.from(productsContainer.querySelectorAll('.o-product-thumbnail'));
    if (!cards.length) return;

    // Store original index for manual sorting
    cards.forEach((card, idx) => {
      card.dataset.originalOrder = idx;
    });

    // State
    const state = {
      topCategory: 'all',
      groups: {
        category: new Set(),
        price: new Set(),
        roast: new Set(),
        brew: new Set(),
        pack: new Set()
      },
      sort: 'manual'
    };

    // 1. Drawer open / close
    function openDrawer() {
      body.classList.add('is-filters-visible');
    }

    function closeDrawer() {
      body.classList.remove('is-filters-visible');
    }

    openDrawerBtns.forEach(btn => btn.addEventListener('click', (e) => {
      e.preventDefault();
      openDrawer();
    }));

    closeDrawerBtns.forEach(btn => btn.addEventListener('click', (e) => {
      e.preventDefault();
      applyFilters();
      closeDrawer();
      // Scroll smoothly to products grid
      if (productsContainer) {
        productsContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
    }));

    if (drawerBg) {
      drawerBg.addEventListener('click', closeDrawer);
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && body.classList.contains('is-filters-visible')) {
        closeDrawer();
      }
    });

    // 2. Accordions toggle inside drawer
    accordionTitles.forEach(title => {
      title.addEventListener('click', (e) => {
        e.preventDefault();
        const group = title.closest('.c-collection-template__faceted-nav__group');
        if (group) {
          group.classList.toggle('is-expanded');
        }
      });
    });

    // 3. Price check helper
    function matchesPrice(cardPrice, priceKey) {
      if (priceKey === 'under-50') return cardPrice < 50000;
      if (priceKey === '50-150') return cardPrice >= 50000 && cardPrice <= 150000;
      if (priceKey === '150-300') return cardPrice > 150000 && cardPrice <= 300000;
      if (priceKey === 'over-300') return cardPrice > 300000;
      return true;
    }

    // 4. Check if a card matches all active filters
    function cardMatches(card) {
      const cardCategory = (card.dataset.category || '').toLowerCase();
      const cardPrice = parseInt(card.dataset.price || '0', 10);
      const cardRoast = (card.dataset.roast || '').toLowerCase();
      const cardBrew = (card.dataset.brew || '').toLowerCase();
      const cardPack = (card.dataset.pack || '').toLowerCase();

      // Top category pill filter
      if (state.topCategory !== 'all') {
        if (!cardCategory.includes(state.topCategory)) {
          return false;
        }
      }

      // Group 1: Category
      if (state.groups.category.size > 0) {
        let matchAny = false;
        state.groups.category.forEach(cat => {
          if (cardCategory.includes(cat)) matchAny = true;
        });
        if (!matchAny) return false;
      }

      // Group 2: Price
      if (state.groups.price.size > 0) {
        let matchAny = false;
        state.groups.price.forEach(p => {
          if (matchesPrice(cardPrice, p)) matchAny = true;
        });
        if (!matchAny) return false;
      }

      // Group 3: Roast
      if (state.groups.roast.size > 0) {
        let matchAny = false;
        state.groups.roast.forEach(r => {
          if (cardRoast.includes(r)) matchAny = true;
        });
        if (!matchAny) return false;
      }

      // Group 4: Brew
      if (state.groups.brew.size > 0) {
        let matchAny = false;
        state.groups.brew.forEach(b => {
          if (cardBrew.includes(b)) matchAny = true;
        });
        if (!matchAny) return false;
      }

      // Group 5: Pack
      if (state.groups.pack.size > 0) {
        let matchAny = false;
        state.groups.pack.forEach(pk => {
          if (cardPack.includes(pk)) matchAny = true;
        });
        if (!matchAny) return false;
      }

      return true;
    }

    // 5. Update UI & products
    function applyFilters() {
      let visibleCount = 0;

      cards.forEach(card => {
        if (cardMatches(card)) {
          card.classList.remove('is-hidden');
          card.style.removeProperty('display');
          visibleCount++;
        } else {
          card.classList.add('is-hidden');
          card.style.setProperty('display', 'none', 'important');
        }
      });

      // Update counters
      countSpans.forEach(span => {
        span.textContent = visibleCount;
      });

      // Calculate total active filter options
      let totalActive = 0;
      Object.keys(state.groups).forEach(grpKey => {
        const count = state.groups[grpKey].size;
        totalActive += count;
        const badge = document.querySelector(`[data-group-count="${grpKey}"]`);
        if (badge) {
          if (count > 0) {
            badge.textContent = `${count} đã chọn`;
            badge.style.display = 'inline-block';
          } else {
            badge.style.display = 'none';
          }
        }
      });

      if (activeFilterCountSpan) {
        activeFilterCountSpan.textContent = totalActive;
      }

      // Empty state
      if (noResultsEl) {
        noResultsEl.style.display = visibleCount === 0 ? 'block' : 'none';
      }
    }

    // 6. Sort products
    function applySort() {
      const sortVal = state.sort;
      const sortedCards = [...cards];

      sortedCards.sort((a, b) => {
        const priceA = parseInt(a.dataset.price || '0', 10);
        const priceB = parseInt(b.dataset.price || '0', 10);
        const titleA = (a.dataset.title || '').trim().toLowerCase();
        const titleB = (b.dataset.title || '').trim().toLowerCase();
        const salesA = parseInt(a.dataset.sales || '0', 10);
        const salesB = parseInt(b.dataset.sales || '0', 10);
        const orderA = parseInt(a.dataset.originalOrder || '0', 10);
        const orderB = parseInt(b.dataset.originalOrder || '0', 10);

        if (sortVal === 'price-ascending') return priceA - priceB;
        if (sortVal === 'price-descending') return priceB - priceA;
        if (sortVal === 'title-ascending') return titleA.localeCompare(titleB, 'vi');
        if (sortVal === 'title-descending') return titleB.localeCompare(titleA, 'vi');
        if (sortVal === 'best-selling') return salesB - salesA;
        return orderA - orderB;
      });

      sortedCards.forEach(card => {
        productsContainer.appendChild(card);
      });
    }

    // 7. Event listeners for Drawer Filter Buttons
    drawerFilterBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        const group = btn.dataset.filterGroup;
        const value = btn.dataset.filterValue;

        if (!state.groups[group]) return;

        if (state.groups[group].has(value)) {
          state.groups[group].delete(value);
          btn.classList.remove('is-selected');
        } else {
          state.groups[group].add(value);
          btn.classList.add('is-selected');
        }

        applyFilters();
      });
    });

    // 8. Event listeners for Top Featured Filter Pills
    topFilterBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        topFilterBtns.forEach(b => {
          b.classList.remove('is-selected');
          b.classList.add('is-ice');
        });
        btn.classList.add('is-selected');
        btn.classList.remove('is-ice');

        state.topCategory = btn.dataset.topFilter || 'all';
        applyFilters();
      });
    });

    // 9. Clear all filters
    function clearAllFilters() {
      // Clear drawer filters
      Object.keys(state.groups).forEach(key => {
        state.groups[key].clear();
      });
      drawerFilterBtns.forEach(btn => btn.classList.remove('is-selected'));

      // Clear top category
      state.topCategory = 'all';
      topFilterBtns.forEach(btn => {
        if (btn.dataset.topFilter === 'all') {
          btn.classList.add('is-selected');
          btn.classList.remove('is-ice');
        } else {
          btn.classList.remove('is-selected');
          btn.classList.add('is-ice');
        }
      });

      applyFilters();
    }

    clearFilterBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        clearAllFilters();
      });
    });

    // 10. Sort dropdown change
    if (sortSelect) {
      sortSelect.addEventListener('change', (e) => {
        state.sort = e.target.value;
        applySort();
      });
    }

    // Initial run
    applyFilters();
    console.log('[S54 Collection Filter] Initialized successfully with', cards.length, 'products.');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initS54Filter);
  } else {
    initS54Filter();
  }
})();
