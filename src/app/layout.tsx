import type{Metadata}from"next";import"./globals.css";
import { FloatingActions } from "@/components/floating-actions";
export const metadata:Metadata={title:"JPL TRADERS | Computers, Electronics & IT Services",description:"JPL TRADERS in Sidhari, Azamgarh: computer sales, repair, office equipment and IT solutions."};
export default function RootLayout({children}:{children:React.ReactNode}){return <html lang="en"><body>{children}<FloatingActions /></body></html>}
