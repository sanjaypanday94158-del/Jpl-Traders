"use client";

import { useEffect, useMemo, useRef, useState } from "react";
import { Search, SlidersHorizontal, X } from "lucide-react";
import { ProductCard } from "@/components/product-card";
import { categories, products } from "@/lib/data";

export function Catalog() {
  const [category, setCategory] = useState("All");
  const [brands, setBrands] = useState<string[]>([]);
  const [sort, setSort] = useState("default");
  const [query, setQuery] = useState("");
  const [visibleCount, setVisibleCount] = useState(10);
  const loadMoreRef = useRef<HTMLDivElement>(null);

  const availableBrands = useMemo(
    () => [...new Set(products.map((product) => product.brand))].sort(),
    [],
  );

  const filtered = useMemo(
    () =>
      products
        .filter((product) => {
          const matchesCategory =
            category === "All" || product.category === category;
          const matchesBrand =
            brands.length === 0 || brands.includes(product.brand);
          const matchesSearch = `${product.name} ${product.brand} ${product.category}`
            .toLowerCase()
            .includes(query.trim().toLowerCase());

          return matchesCategory && matchesBrand && matchesSearch;
        })
        .sort((a, b) =>
          sort === "low"
            ? a.price - b.price
            : sort === "high"
              ? b.price - a.price
              : a.id - b.id,
        ),
    [category, brands, sort, query],
  );

  const hasFilters = category !== "All" || brands.length > 0 || query.length > 0;
  const visibleProducts = filtered.slice(0, visibleCount);

  useEffect(() => {
    setVisibleCount(10);
  }, [category, brands, sort, query]);

  useEffect(() => {
    const sentinel = loadMoreRef.current;
    if (!sentinel || visibleCount >= filtered.length) return;

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setVisibleCount((current) =>
            Math.min(current + 10, filtered.length),
          );
        }
      },
      { rootMargin: "160px" },
    );

    observer.observe(sentinel);
    return () => observer.disconnect();
  }, [filtered.length, visibleCount]);

  function toggleBrand(brand: string) {
    setBrands((current) =>
      current.includes(brand)
        ? current.filter((item) => item !== brand)
        : [...current, brand],
    );
  }

  function clearFilters() {
    setCategory("All");
    setBrands([]);
    setQuery("");
    setSort("default");
  }

  return (
    <main className="bg-[#f7f8fa]">
      <div className="shell py-8 md:py-10">
        <div className="mb-6 flex flex-wrap items-end justify-between gap-4 border-b border-slate-200 pb-5">
          <div>
            <h1 className="text-[28px] font-extrabold leading-tight tracking-[-0.04em] text-[#082653] sm:text-3xl">
              Shop <span className="text-[#0757c8]">Products</span>
            </h1>
            <div
              aria-hidden="true"
              className="mt-2.5 h-[3px] w-16 rounded-full bg-gradient-to-r from-[#0757c8] to-[#ff7915]"
            />
          </div>
          <div
            className="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 shadow-[0_2px_8px_rgba(8,40,90,0.06)]"
            aria-live="polite"
          >
            <span className="h-2 w-2 rounded-full bg-[#0757c8]" />
            <span className="font-bold text-[#082653]">{filtered.length}</span>
            {filtered.length === 1 ? "product" : "products"}
          </div>
        </div>

        <div className="grid items-start gap-5 lg:grid-cols-[232px_minmax(0,1fr)] lg:gap-6">
          <aside
            aria-label="Product filters"
            className="h-fit rounded-xl border border-slate-200 bg-white p-4 shadow-[0_2px_8px_rgba(15,23,42,0.04)]"
          >
            <div className="flex items-center justify-between border-b border-slate-100 pb-3">
              <h2 className="flex items-center gap-2 text-sm font-bold text-[#082653]">
                <SlidersHorizontal size={15} className="text-slate-500" />
                Filter by
              </h2>
              {hasFilters && (
                <button
                  type="button"
                  onClick={clearFilters}
                  className="text-xs font-semibold text-[#0757c8] hover:underline"
                >
                  Clear all
                </button>
              )}
            </div>

            <fieldset className="mt-4">
              <legend className="mb-2 text-xs font-bold text-slate-700">
                Category
              </legend>
              <div className="space-y-0.5">
                {["All", ...categories].map((item) => {
                  const count =
                    item === "All"
                      ? products.length
                      : products.filter((product) => product.category === item)
                          .length;

                  return (
                    <label
                      key={item}
                      className={`flex cursor-pointer items-center justify-between rounded-md px-2.5 py-2 text-xs transition-colors ${
                        category === item
                          ? "bg-blue-50 font-semibold text-[#0757c8]"
                          : "text-slate-600 hover:bg-slate-50"
                      }`}
                    >
                      <span className="flex items-center gap-2">
                        <input
                          type="radio"
                          name="product-category"
                          value={item}
                          checked={category === item}
                          onChange={() => setCategory(item)}
                          className="h-3.5 w-3.5 accent-[#0757c8]"
                        />
                        {item === "All" ? "All categories" : item}
                      </span>
                      <span className="text-[10px] text-slate-400">{count}</span>
                    </label>
                  );
                })}
              </div>
            </fieldset>

            <fieldset className="mt-4 border-t border-slate-100 pt-4">
              <legend className="mb-2 text-xs font-bold text-slate-700">
                Brand
              </legend>
              <div className="space-y-0.5">
                {availableBrands.map((brand) => {
                  const count = products.filter(
                    (product) => product.brand === brand,
                  ).length;

                  return (
                    <label
                      key={brand}
                      className="flex cursor-pointer items-center justify-between rounded-md px-2.5 py-2 text-xs text-slate-600 transition-colors hover:bg-slate-50"
                    >
                      <span className="flex items-center gap-2">
                        <input
                          type="checkbox"
                          checked={brands.includes(brand)}
                          onChange={() => toggleBrand(brand)}
                          className="h-3.5 w-3.5 rounded accent-[#0757c8]"
                        />
                        {brand}
                      </span>
                      <span className="text-[10px] text-slate-400">{count}</span>
                    </label>
                  );
                })}
              </div>
            </fieldset>
          </aside>

          <section aria-label="Products">
            <div className="mb-4 flex flex-wrap items-center gap-3 rounded-xl border border-slate-200 bg-white p-2.5 shadow-[0_2px_8px_rgba(15,23,42,0.03)]">
              <div className="flex min-w-[220px] flex-1 items-center gap-2.5 px-2">
                <Search size={17} className="shrink-0 text-slate-400" />
                <input
                  value={query}
                  onChange={(event) => setQuery(event.target.value)}
                  placeholder="Search products or brands"
                  aria-label="Search products or brands"
                  className="min-w-0 flex-1 border-0 bg-transparent py-2 text-sm text-slate-800 outline-none placeholder:text-slate-400"
                />
                {query && (
                  <button
                    type="button"
                    onClick={() => setQuery("")}
                    aria-label="Clear search"
                    className="rounded p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                  >
                    <X size={15} />
                  </button>
                )}
              </div>
              <label className="flex items-center gap-2 border-l border-slate-200 pl-3 text-xs text-slate-500">
                <span className="whitespace-nowrap">Sort:</span>
                <select
                  value={sort}
                  onChange={(event) => setSort(event.target.value)}
                  className="max-w-40 bg-transparent py-2 pr-1 text-xs font-semibold text-[#082653] outline-none"
                  aria-label="Sort products"
                >
                  <option value="default">Default</option>
                  <option value="low">Price: Low to High</option>
                  <option value="high">Price: High to Low</option>
                </select>
              </label>
            </div>

            {hasFilters && (
              <div className="mb-4 flex flex-wrap items-center gap-2">
                {category !== "All" && (
                  <span className="rounded-md border border-slate-200 bg-white px-2.5 py-1.5 text-xs text-slate-600">
                    {category}
                  </span>
                )}
                {brands.map((brand) => (
                  <button
                    key={brand}
                    type="button"
                    onClick={() => toggleBrand(brand)}
                    className="inline-flex items-center gap-1.5 rounded-md border border-slate-200 bg-white px-2.5 py-1.5 text-xs text-slate-600 hover:border-slate-300"
                    aria-label={`Remove ${brand} brand filter`}
                  >
                    {brand}
                    <X size={12} />
                  </button>
                ))}
                {query && (
                  <span className="rounded-md border border-slate-200 bg-white px-2.5 py-1.5 text-xs text-slate-600">
                    Search: {query}
                  </span>
                )}
                <button
                  type="button"
                  onClick={clearFilters}
                  className="px-1 text-xs font-semibold text-[#0757c8] hover:underline"
                >
                  Clear all
                </button>
              </div>
            )}

            {filtered.length > 0 ? (
              <>
                <div className="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                {visibleProducts.map((product) => (
                  <ProductCard key={product.id} p={product} />
                ))}
                </div>
                {visibleCount < filtered.length && (
                  <div
                    ref={loadMoreRef}
                    className="mt-7 flex flex-col items-center gap-2 py-3"
                  >
                    <p className="text-xs text-slate-500" aria-live="polite">
                      Showing {visibleProducts.length} of {filtered.length} products
                    </p>
                    <button
                      type="button"
                      onClick={() =>
                        setVisibleCount((current) =>
                          Math.min(current + 10, filtered.length),
                        )
                      }
                      className="rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-[#082653] transition-colors hover:border-[#0757c8] hover:text-[#0757c8]"
                    >
                      Load 10 more products
                    </button>
                  </div>
                )}
              </>
            ) : (
              <div className="rounded-xl border border-slate-200 bg-white px-6 py-14 text-center">
                <p className="font-semibold text-[#082653]">
                  No products found
                </p>
                <p className="mt-1.5 text-sm text-slate-500">
                  Change your filters or try a different search.
                </p>
                <button
                  type="button"
                  onClick={clearFilters}
                  className="mt-4 rounded-lg bg-[#0757c8] px-4 py-2 text-xs font-bold text-white hover:bg-[#0648a7]"
                >
                  Clear filters
                </button>
              </div>
            )}
          </section>
        </div>
      </div>
    </main>
  );
}
