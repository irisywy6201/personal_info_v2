function FindProxyForURL(url,host) {
  //if(dnsDomainIs(host, ".tw")) 
  //  return "DIRECT";

  var lchost = host.toLowerCase();

  // Google Global Cache
  if(withSuffix(lchost, "google.com") || withSuffix(lchost, "google.com.tw"))
    return "DIRECT";

  if(dnsDomainIs(host, "infoweb.newsbank.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.acm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "delivery.acm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pubs.acs.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pubs3.acs.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "cen.acs.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jobspectrum.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "db.usenix.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "advan.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ageing.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.aidsonline.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "ojps.aip.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.allenpress.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.aafp.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "webster.aip.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl.ajcn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ajcn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.amjdermatopathology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "aje.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ashp.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ajkd.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.harcourthealth.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.amjpathol.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.amjphysmedrehab.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.aapt.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-ajpcon.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ajrccm.atsjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-ajrccm.atsjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ajrcmb.atsjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-ajrcmb.atsjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ajsp.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "1protein.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.anb.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.asis.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.asme.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ams.allenpress.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "arpa.allenpress.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.anesthesia-analgesia.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.anesthesiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.annalsofsurgery.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "ard.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "annualreviews.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "biochem.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "biophys.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "cellbio.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ento.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "genet.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "immunol.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "med.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "micro.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "neuro.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pharmtox.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "physiol.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "publhealth.annualreviews.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.annals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "aac.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "aac.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archderm.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "adc.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "archfaci.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archfami.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archpsyc.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archinte.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archneur.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archopht.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archotol.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archpedi.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "archsurg.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "arpa.allenpress.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.hwwilson.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "atvb.ahajournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.atvbaha.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.pubs.asce.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ce-ux-1.asce.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.aslib.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.journals.asm.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cardiosource.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.publish.csiro.au"))
    return "DIRECT";

  if(dnsDomainIs(host, "ets.umdl.umich.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.biochemj.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "bioinformatics.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "bones.med.ohio-state.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "hsl-proxy.med.ohio-state.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.blackwell-synergy.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.blackwell-science.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.bloodjournal.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "web.bma.org.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "brain.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "bal-ms.bridgeman.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.bir.org.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "clorinda.catchword.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "bjo.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.bmj.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cancer.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cabi.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.journals.cup.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "journals.cambridge.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.journals.cambridge.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.csa.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.csa2.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "mars.csa.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "mars2.csa.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "cancerres.aacrjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "cebp.aacrjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "carcin.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.catchword.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cell.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "download.cell.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "cgd.aacrjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pci.chadwyck.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "pci.chadwyck.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "pcift.chadwyck.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "pcift.chadwyck.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "pcift.global.chadwyck.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "cheme-a.umche.maine.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.chemvillage.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.oxmill.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.circulationaha.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "circres.ahajournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.circresaha.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "clincancerres.aacrjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.clinicalevidence.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "cmr.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.clinnephrol.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.nuclearmed.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.clinicalobgyn.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.corronline.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "cs.portlandpress.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cios.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.corneajrnl.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ccmjournal.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jws-edck.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.mrw2.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "alt3.csa3.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.co-gastroenterology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.co-hematology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.co-infectiousdiseases.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.co-neurology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.co-pediatrics.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.co-rheumatology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "source.datastream.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "mvstcp1.swets.nl"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.dataswetsconnect.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.swetsblackwell.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "dekker.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.math.ucdavis.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "products.dialog.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.dialog.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.dialogselect.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "library.dialog.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.dialogweb.com                    "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.digitalcurriculum.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.discolrect.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "dmd.aspetjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.dukemathjournal.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-24.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-45.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-46.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-47.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-48.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-49.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-50.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-51.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-52.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-53.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-54.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-55.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-56.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-57.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-58.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-59.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-60.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "ebsco-publishing-167-61.digisle.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "global.epweb.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "putski.global.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ebsco.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.global.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.global.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www-tw.ebsco.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "search.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "eadmin.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "pagecomposer1.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "webauth2.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "Ehostvgw5.epnet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "u1200b.economist.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.edpsciences.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "edrs.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "orders.edrs.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "countrydata.bvdep.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.eiu.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.eiu.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www3.electrochem.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.electrochem.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.elsevier.co.jp "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.elsevier.nl"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.elsevier.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.sciencedirect.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.embase.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.emboj.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "embo-reports.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.emeraldinsight.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.emerald-library.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cdc.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.els.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ei.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ehis.niehs.nih.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.accesseric.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ed.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.europeaninternet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.eje.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.fasebj.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.fcla.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.futuraco.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "galenet.galegroup.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.genesdev.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.genetics.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.genomebiology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "geosociety.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.globalbooksinprint.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "netra.newsbank.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "glycob.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ea.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "gi.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "gme.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "gmesantaclara.wip.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "go.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "logs.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "lp.grolier.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "nbk.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "nbk.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "nbk.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "nbkprod.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "nbps.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "nec.grolier.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "ntwww.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "publishing.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "scratchy.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "stats.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "tc98.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.go.grolier.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "gosrch.grolier.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.groveart.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.grovemusic.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "gut.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.mosby.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.harcourt-international.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.harrisonsonline.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.healthatoz.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.healthfinder.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.healthgate.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www3.healthgate.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "heart.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "hepatology.aasldjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-hepatology.aasldjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.hosppract.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.hypertensionaha.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ibisworld.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.idealibrary.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "computer.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "search2.computer.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "dlib.computer.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "dlib2.computer.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "church.computer.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "sphinx5.ieee.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ieee-infocom.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ieeexplore.ieee.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ieee.orgieee.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.immunity.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.iospress.nl"))
    return "DIRECT";

  if(dnsDomainIs(host, "iospress.metapress.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "inca.math.indiana.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "iai.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ingenta.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www-fourier.ujf-grenoble.fr"))
    return "DIRECT";

  if(dnsDomainIs(host, "newton.ioppublishing.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "maik.maik.rssi.ru "))
    return "DIRECT";

  if(dnsDomainIs(host, "ije.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "journals.iucr.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "igm.nlm.nih.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "pubsonline.informs.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.itsmarc.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "jac.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jama.ama-assn.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jama.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "isiknowledge.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "jcr1.isiknowledge.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "isi0.isiknowlede.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-jap.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jap.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jb.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jbc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jbjs.kfinder.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jbmr-online.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cardiovascularpharm.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jcb.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jchemed.chem.wisc.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jcge.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jco.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ojps.aip.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jci.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jcm.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jcomputertomography.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "journals.endocrinology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jech.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ectjournal.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jem.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jgp.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jhypertension.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "jimmunol.HighWire.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jimmunol.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "vir.sgmjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jlr.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jmg.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "mollus.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-jn.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jn.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jneurosci.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.thejns-net.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.nutrition.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www1.mosby.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jpho-online.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.perio.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jpet.aspetjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jphysiol.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jrf-journals.org.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jaacap.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jasn.org  "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.cardiosource.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-jnci.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jnci.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.thoracicimaging.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jtrauma.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jurology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "jvi.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "jstor1.mcc.ac.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "mjstor01.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "mjstor11.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "mjstor03.engin.umich.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "mjstor07.engin.umich.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "mvip.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ns.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pjstor5.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pvip.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pf1.jstor.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "muse.jhu.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.wkap.nl"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.kluweronline.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "labinvest.uscapjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.thelancet.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.uli.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.laryngoscope.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.lexis-nexis.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.lexis.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.uidaho.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "LINK.springer.de"))
    return "DIRECT";

  if(dnsDomainIs(host, "link.springer-ny.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "lww.comservices.lww.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.lrponline.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.lisanet.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.lwwoncology.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.nejm.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ams.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.sciencedirect.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.mdconsult.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.lww-medicalcare.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.mwsearch.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "LWWmedicine.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.md-journal.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.acsm-msse.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.medscape.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "mmbr.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "modpath.uscapjournals.org  "))
    return "DIRECT";

  if(dnsDomainIs(host, "mcb.asm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl.molbiolevol.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.molbiolevol.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.molecule.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "molpharm.aspetjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.hppmusicindex.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ncbi.nlm.nih.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.net.nih.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "biotech.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "cellbio.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "genetics.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "medicine.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "neurosci.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "structbio.nature.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.nber.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.netlibrary.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.neurology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.neurosurgery-online.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.neuron.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.nejm.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "nar.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "oem.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "connexion.global.oclc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "connexion.oclc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "firstsearch.oclc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "firstsearch.global.oclc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "newfirstsearch.global.oclc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.oclc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ohiolink.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "olc1.ohiolink.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ellispub.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.naturesj.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.osa.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.opticsinfobase.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "otology-neurotology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "gateway.ovid.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ovid.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "gateway2.ovid.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www4.oup.co.uk "))
    return "DIRECT";

  if(dnsDomainIs(host, "www.pedresearch.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl.pediatrics.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "pedsinreview.aapjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.pidj.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.jpharmacogenetics.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "pharmrev.aspetjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pra.aps.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "prb.aps.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "prc.aps.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "prd.aps.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "pre.aps.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "prl.aps.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.aps.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "rmp.aps.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "prst-ab.aps.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-physrev.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "physrev.physiology.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.phytoparasitica.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.plasreconsurg.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.pnas.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "pmj.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "prola.aps.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "global.umi.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "proquest.umi.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.bellhowell.infolearning.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "wwwlib.umi.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "wwwlib.global.umi.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-psychservices.psychiatryonline.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "psychservices.psychiatryonline.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ajgp.psychiatryonline.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "ajp.psychiatryonline.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl-radiology.rsnajnls.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "rheumatology.oupjournals.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.rep.routledge.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.rsc.orgpubs.rsc.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.sciencemag.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.sciencedirect.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "sci1.cas.orgsci2.cas.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.sciamarchive.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.sciam.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "sti.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "epubs.siam.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.simmons.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.imaging.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "su52.siam.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.socgenmicrobiol.org.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.spie.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.spinejournal.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.datastarweb.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.springer-ny.com "))
    return "DIRECT";

  if(dnsDomainIs(host, "online.statref.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "stroke.ahajournals.org "))
    return "DIRECT";

  if(dnsDomainIs(host, "mitpress.mit.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.surgical-laparoscopy.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.swetsnetnavigator.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.swetsnetnavigator.nl"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.swetswise.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.blackwell-synergy.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.drug-monitoring.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.t-telford.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.t-telford.co.uk"))
    return "DIRECT";

  if(dnsDomainIs(host, "thorax.bmjjournals.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "intl.transfusion.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.transfusion.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.turpion.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "web.lexis-nexis.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.ulrichsweb.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "uncweb.carl.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.journals.uchicago.edu"))
    return "DIRECT";

  if(dnsDomainIs(host, "www2.uspto.gov"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.wbsaunders.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.w3.org"))
    return "DIRECT";

  if(dnsDomainIs(host, "interactive.wsj.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "public.wsj.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "isiknowledge.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "jcr1.isiknowledge.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "isi0.isiknowlede.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.westlaw.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "westlawcampus.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "uk.westlaw.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "international.westlaw.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www3.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www3.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.mrw.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.mrw2.intescience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.expressexec.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.demo.interscience.wiley.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "twawisenews.wisers.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.worldscientific.com"))
    return "DIRECT";

  if(dnsDomainIs(host, "ejournals.worldscientific.com.sg"))
    return "DIRECT";

  if(dnsDomainIs(host, "www.global.cnki.net"))
    return "DIRECT";

  if(dnsDomainIs(host, "sdos.ejournal.accs.net"))
    return "DIRECT";

  // AS7539
  // 目的 TWAREN IP 不走 Proxy
  if ( isInNet(host, "211.73.64.0","255.255.224.0") || isInNet(host, "211.73.70.0","255.255.255.0") ||
       isInNet(host,"211.79.48.0","255.255.240.0"))
    return "DIRECT";

  // AS9264
  // 目的 Sinica IP 不走 Proxy
  if ( isInNet(host, "120.126.0.0","255.255.224.0") || isInNet(host, "120.126.32.0","255.255.224.0") ||
       isInNet(host, "120.126.64.0","255.255.224.0") || isInNet(host, "120.120.96.0","255.255.255.240") ||
       isInNet(host, "140.109.0.0","255.255.0.0") || isInNet(host, "163.25.86.0","255.255.255.0") ||
       isInNet(host, "163.25.87.0","255.255.255.0") || isInNet(host, "163.25.88.0","255.255.255.0") ||
       isInNet(host, "163.25.89.0","255.255.255.0") || isInNet(host, "192.192.228.0","255.255.255.0") ||
       isInNet(host, "192.192.229.0","255.255.255.0") || isInNet(host, "202.169.160.0","255.255.255.240"))
    return "DIRECT";

  // AS1659
  // 目的 TANet IP 不走 Proxy
  if ( isInNet(host,"134.208.0.0","255.255.0.0") || isInNet(host,"140.109.0.0","255.255.0.0") || 
       isInNet(host,"140.110.0.0","255.254.0.0") || isInNet(host,"140.112.0.0","255.240.0.0") ||
       isInNet(host,"140.127.0.0","255.255.0.0") || isInNet(host,"140.128.0.0","255.248.0.0") || 
       isInNet(host,"140.131.0.0","255.254.0.0") || isInNet(host,"140.134.0.0","255.252.0.0") || 
       isInNet(host,"140.92.0.0","255.255.0.0") || isInNet(host,"140.96.0.0","255.255.0.0") || 
       isInNet(host,"163.13.0.0","255.240.0.0") || isInNet(host,"163.32.0.0","255.255.0.0") ||
       isInNet(host,"192.83.166.0","255.255.254.0") || isInNet(host,"192.83.168.0","255.255.248.0") || 
       isInNet(host,"192.83.176.0","255.255.240.0") || isInNet(host,"192.83.192.0","255.255.252.0") || 
       isInNet(host,"192.83.196.0","255.255.255.0") || isInNet(host,"192.192.0.0","255.255.0.0") ||
       isInNet(host,"203.64.0.0","255.255.0.0") || isInNet(host,"203.67.0.0","255.254.0.0") || 
       isInNet(host,"203.71.0.0","255.253.0.0") || isInNet(host,"203.72.0.0","255.255.0.0") ||
       isInNet(host,"210.59.0.0","255.255.128.0") || isInNet(host,"210.60.0.0","255.255.0.0") || 
       isInNet(host,"210.62.64.0","255.255.224.0") || isInNet(host,"210.62.224.0","255.255.240.0") ||
       isInNet(host,"210.62.240.0","255.255.248.0") || isInNet(host,"210.68.0.0","255.255.255.0") || 
       isInNet(host,"210.70.0.0","255.255.0.0") || isInNet(host,"210.71.0.0","255.255.128.0") ||
       isInNet(host,"210.200.32.0","255.255.224.0") || isInNet(host,"210.240.0.0","255.255.0.0") || 
       isInNet(host,"210.243.0.0","255.255.128.0") )
     return "DIRECT";

  if (isInNet(host, "10.0.0.0", "255.0.0.0") || isInNet(host, "127.0.0.0", "255.0.0.0") ||
      isInNet(host, "172.16.0.0", "255.240.0.0") || isInNet(host, "192.168.0.0", "255.255.0.0"))
    return "DIRECT";

  return "PROXY proxy.csie.ncu.edu.tw:3128; PROXY proxy.ncu.edu.tw:3128; DIRECT";
}

function withPrefix(str, prefix) {
        return (str.indexOf(prefix) == 0);
}
function withSuffix(str, suffix) {
        var n = str.lastIndexOf(suffix);
        return (n >= 0 && n + suffix.length == str.length);
}
function contains(str, tok) {
        return (str.indexOf(tok) > 0);
}
