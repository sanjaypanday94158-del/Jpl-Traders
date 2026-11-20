import { Catalog } from "@/components/catalog";
import { PageHero } from "@/components/page-hero";

export default function Products() {
  return (
    <>
      <PageHero
        title="Shop Products"
        subtitle="Explore computers, printers, accessories and more."
        image="/banners/products-banner.png"
      />
      <Catalog />
    </>
  );
}