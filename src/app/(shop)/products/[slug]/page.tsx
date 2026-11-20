import{notFound}from"next/navigation";import{products}from"@/lib/data";import{ProductDetail}from"@/components/product-detail";
export default async function ProductPage({params}:{params:Promise<{slug:string}>}){const{slug}=await params;const p=products.find(x=>x.slug===slug);if(!p)notFound();return <ProductDetail p={p}/>}
export function generateStaticParams(){return products.map(p=>({slug:p.slug}))}
