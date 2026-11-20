export type Product={id:number;slug:string;name:string;category:string;brand:string;price:number;oldPrice:number;rating:number;image:string;description:string};
export const products:Product[]=[
{id:1,slug:"dell-inspiron-15",name:"Dell Inspiron 15 Laptop",category:"Laptops",brand:"Dell",price:54990,oldPrice:66990,rating:4.5,image:"https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=650&q=85",description:"15.6-inch Full HD display, 8GB RAM, SSD storage"},
{id:2,slug:"hp-pavilion",name:"HP Pavilion Laptop",category:"Laptops",brand:"HP",price:56990,oldPrice:71990,rating:4.6,image:"https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=650&q=85",description:"Powerful and portable laptop for everyday productivity"},
{id:3,slug:"lenovo-desktop",name:"Lenovo Desktop Computer",category:"Desktops",brand:"Lenovo",price:39990,oldPrice:46990,rating:4.4,image:"https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=650&q=85",description:"Business desktop solution for office productivity"},
{id:4,slug:"lg-monitor",name:"LG 24-inch Full HD Monitor",category:"Monitors",brand:"LG",price:10990,oldPrice:14990,rating:4.6,image:"https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=650&q=85",description:"Full HD IPS display, slim bezel and vivid colors"},
{id:5,slug:"hp-laserjet",name:"HP LaserJet Multifunction Printer",category:"Printers",brand:"HP",price:14490,oldPrice:17990,rating:4.5,image:"https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=650&q=85",description:"Print, scan and copy for home or office"},
{id:6,slug:"asus-vivobook",name:"ASUS VivoBook Laptop",category:"Laptops",brand:"ASUS",price:59990,oldPrice:64990,rating:4.4,image:"https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=650&q=85",description:"Modern laptop with fast storage and premium finish"},
{id:7,slug:"wireless-computer-mouse",name:"Wireless Computer Mouse",category:"Accessories",brand:"Logitech",price:799,oldPrice:1199,rating:4.5,image:"https://images.unsplash.com/photo-1527814050087-3793815479db?w=650&q=85",description:"Wireless mouse for smooth everyday computer use"},
{id:8,slug:"premium-laptop",name:"Premium Laptop",category:"Laptops",brand:"Apple",price:74990,oldPrice:84990,rating:4.6,image:"https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=650&q=85",description:"Portable laptop for work, study and everyday productivity"}
];
export const categories=["Laptops","Desktops","Monitors","Printers","Photocopiers","Accessories","Networking","Components"];
export const services=["Computer & Laptop Repair","Printer & Photocopier Service","AMC & Maintenance","Software Installation","Data Recovery","Network Setup","Bulk IT Supply","On-site Support"];
export const heroSlides=[
{image:"/banners/jpl-promo-1.webp",tag:"COMPUTERS • GADGETS • ACCESSORIES",title:"Technology that powers your everyday.",subtitle:"Explore laptops, desktops, CPU components, printers, mouse and computer accessories.",button:"Shop Products",href:"/products"},
{image:"/banners/jpl-promo-2.webp",tag:"OFFICE EQUIPMENT & SUPPORT",title:"Complete solutions for your office.",subtitle:"Photocopiers, printers, office technology and professional IT services from JPL TRADERS.",button:"Our Services",href:"/services"},
{image:"/banners/jpl-promo-3.webp",tag:"VISIT OUR STORE • SIDHARI, AZAMGARH",title:"Your local technology partner.",subtitle:"Visit JPL TRADERS for computer equipment, hardware and personalised product assistance.",button:"About Our Store",href:"/about"}
];
